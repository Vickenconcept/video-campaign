<?php

namespace App\Http\Controllers\VideoPage;

use App\Http\Controllers\Controller;
use App\Models\EmailCampaign;
use App\Models\EmailRecipient;
use App\Jobs\SendEmailCampaignJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VideoEmailCampaignMailable;
use App\Models\EmailReply;
use Illuminate\Support\Str;
use App\Models\EmailFolder;

class VideoPageController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailCampaign::where('user_id', Auth::id())
            ->where('type', 'video_page')
            ->with(['folder'])
            ->withCount(['recipients as total_recipients']);

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by folder
        if ($request->filled('folder') && $request->folder !== 'all') {
            $query->where('email_folder_id', $request->folder);
        }

        // Search by title or subject
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $campaigns = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get folders for filter dropdown
        $folders = EmailFolder::where('user_id', Auth::id())->orderBy('name')->get();

        return view('video_page.campaigns.index', compact('campaigns', 'folders'));
    }

    public function create()
    {
        return view('video_page.campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'video_url' => 'required|url',
            'thumbnail_url' => 'required|url',
            'cta_url' => 'required|url',
            'cta_text' => 'required|string|max:255',
            'scheduled_at' => 'nullable|date|after:now',
            'recipients' => 'required|string',
        ]);

        $scheduledAt = null;
        if ($request->scheduled_at) {
            $scheduledAt = \Carbon\Carbon::parse($request->scheduled_at, config('app.timezone'))->setTimezone('UTC');
        }

        $campaign = EmailCampaign::create([
            'user_id' => Auth::id(),
            'email_folder_id' => $request->email_folder_id ?: null,
            'title' => $request->title,
            'subject' => $request->subject,
            'body' => $request->body,
            'video_url' => $request->video_url,
            'thumbnail_url' => $request->thumbnail_url,
            'cta_url' => $request->cta_url,
            'cta_text' => $request->cta_text,
            'scheduled_at' => $scheduledAt,
            'status' => $scheduledAt ? 'scheduled' : 'sent',
            'template_data' => $request->input('template_data', []),
            'type' => 'video_page',
        ]);

        // Parse recipients (comma-separated emails)
        $emails = array_filter(array_map('trim', explode(',', $request->recipients)));

        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                EmailRecipient::create([
                    'email_campaign_id' => $campaign->id,
                    'email' => $email,
                    'uuid' => (string) Str::uuid(),
                ]);
            }
        }

        // Schedule job if scheduled_at is set
        if ($scheduledAt) {
            SendEmailCampaignJob::dispatch($campaign)->delay($scheduledAt);
        } else {
            SendEmailCampaignJob::dispatch($campaign);
        }

        return redirect()->route('video-page.campaigns.index')
            ->with('success', 'Page created successfully!');
    }

    public function show(EmailCampaign $campaign)
    {
        // $this->authorize('view', $campaign);

        $recipients = $campaign->recipients()->orderByDesc('created_at')->paginate(10);

        $stats = [
            'total_recipients' => $campaign->recipients()->count(),
            'opened' => $campaign->recipients()->whereNotNull('opened_at')->count(),
            'viewed' => $campaign->recipients()->whereNotNull('viewed_at')->count(),
            'clicked' => $campaign->recipients()->whereNotNull('clicked_at')->count(),
        ];
        // Count total replies for this campaign
        $totalReplies = EmailReply::whereIn('email_recipient_id', $campaign->recipients()->pluck('uuid'))->count();
        // Get reply counts for each recipient (by uuid)
        $recipientReplyCounts = collect();
        foreach ($recipients as $recipient) {
            $recipientReplyCounts[$recipient->uuid] = $recipient->replies()->count();
        }
        return view('video_page.campaigns.show', compact('campaign', 'stats', 'totalReplies', 'recipientReplyCounts', 'recipients'));
    }

    public function edit(EmailCampaign $campaign)
    {
        // $this->authorize('update', $campaign);

        $campaign->load('recipients');
        $recipients = $campaign->recipients->pluck('email')->implode(', ');

        return view('video_page.campaigns.edit', compact('campaign', 'recipients'));
    }

    public function update(Request $request, EmailCampaign $campaign)
    {
        // $this->authorize('update', $campaign);

        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'video_url' => 'required|url',
            'thumbnail_url' => 'required|url',
            'cta_url' => 'required|url',
            'cta_text' => 'required|string|max:255',
            'scheduled_at' => 'nullable|date|after:now',
            'recipients' => 'required|string',
        ]);

        $scheduledAt = null;
        if ($request->scheduled_at) {
            $scheduledAt = \Carbon\Carbon::parse($request->scheduled_at, config('app.timezone'))->setTimezone('UTC');
        }

        $campaign->update([
            'email_folder_id' => $request->email_folder_id ?: null,
            'title' => $request->title,
            'subject' => $request->subject,
            'body' => $request->body,
            'video_url' => $request->video_url,
            'thumbnail_url' => $request->thumbnail_url,
            'cta_url' => $request->cta_url,
            'cta_text' => $request->cta_text,
            'scheduled_at' => $scheduledAt,
            'status' => $scheduledAt ? 'scheduled' : 'draft',
            'template_data' => $request->input('template_data', []),
        ]);

        // Update recipients (preserve existing, add new, remove missing)
        $emails = array_filter(array_map('trim', explode(',', $request->recipients)));
        $existingRecipients = $campaign->recipients()->get()->keyBy('email');
        $newEmails = collect($emails);
        $existingEmails = $existingRecipients->keys();

        // Add new recipients
        foreach ($newEmails->diff($existingEmails) as $email) {
            EmailRecipient::create([
                'email_campaign_id' => $campaign->id,
                'email' => $email,
                'uuid' => (string) Str::uuid(),
            ]);
        }
        // Remove recipients that are no longer present
        foreach ($existingEmails->diff($newEmails) as $email) {
            $existingRecipients[$email]->delete();
        }
        // (Optional) Update any other fields for existing recipients if needed

        // Schedule job if scheduled_at is set
        if ($scheduledAt) {
            SendEmailCampaignJob::dispatch($campaign)->delay($scheduledAt);
        }

        return redirect()->route('video-page.campaigns.index')
            ->with('success', 'Campaign updated successfully!');
    }

    public function destroy(EmailCampaign $campaign)
    {
        // $this->authorize('delete', $campaign);

        $campaign->delete();

        return redirect()->route('video_page.campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }

    public function preview(EmailCampaign $campaign)
    {
        // $this->authorize('view', $campaign);

        return view('video_page.campaigns.preview', compact('campaign'));
    }

    public function previewIframe(EmailCampaign $campaign)
    {
        // $this->authorize('view', $campaign);

        // Create a dummy recipient for preview purposes
        $dummyRecipient = new EmailRecipient([
            'email_campaign_id' => $campaign->id,
            'email' => 'preview@example.com',
            'uuid' => (string) Str::uuid(),
        ]);

        // Use the same template view that will be used for sending
        $templateView = 'video_page.campaigns.templates.' . $campaign->template;

        return view($templateView, [
            'campaign' => $campaign,
            'recipient' => $dummyRecipient,
            'brandSettings' => $campaign->user->getBrandSettings(),
            'trackingPixel' => '#',
            'viewUrl' => $campaign->video_url,
            'clickUrl' => $campaign->cta_url,
        ]);
    }

    public function sendNow(EmailCampaign $campaign)
    {
        // $this->authorize('update', $campaign);

        if ($campaign->status === 'sent') {
            return back()->with('error', 'Campaign has already been sent!');
        }

        $campaign->update(['status' => 'sent']);

        // Send emails immediately
        SendEmailCampaignJob::dispatch($campaign);

        return back()->with('success', 'Campaign sent successfully!');
    }

    public function templates(EmailCampaign $campaign)
    {
        // $this->authorize('view', $campaign);

        return view('video_page.campaigns.templates', compact('campaign'));
    }

   


    public function importFromVideoCampaigns(Request $request)
    {
        $request->validate([
            'campaign_ids' => 'required|array',
            'campaign_ids.*' => 'exists:campaigns,id'
        ]);

        $emails = \App\Models\Response::whereIn('step_id', function ($query) use ($request) {
            $query->select('id')
                ->from('steps')
                ->whereIn('campaign_id', $request->campaign_ids);
        })
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->distinct()
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        return response()->json([
            'success' => true,
            'emails' => $emails,
            'count' => count($emails)
        ]);
    }

    public function importFromExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $import = new \App\Imports\EmailImport();
            \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('excel_file'));

            $emails = $import->getEmails();

            return response()->json([
                'success' => true,
                'emails' => $emails,
                'count' => count($emails)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error importing file: ' . $e->getMessage()
            ], 422);
        }
    }

    public function embed(EmailCampaign $campaign)
    {
        // Create a dummy recipient for embed purposes
        $dummyRecipient = new \App\Models\EmailRecipient([
            'email_campaign_id' => $campaign->id,
            'email' => 'embed@example.com',
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
        ]);
        $templateView = 'video_page.campaigns.templates.' . $campaign->template;
        $html = view($templateView, [
            'campaign' => $campaign,
            'recipient' => $dummyRecipient,
            'brandSettings' => $campaign->user->getBrandSettings(),
            'trackingPixel' => '#',
            'viewUrl' => $campaign->video_url,
            'clickUrl' => $campaign->cta_url,
        ])->render();
        return view('video_page.campaigns.embed', [
            'campaign' => $campaign,
            'html' => $html,
        ]);
    }
}
