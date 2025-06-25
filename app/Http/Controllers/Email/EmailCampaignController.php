<?php

namespace App\Http\Controllers\Email;

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

class EmailCampaignController extends Controller
{
    public function index()
    {
        $campaigns = EmailCampaign::where('user_id', Auth::id())
            ->withCount(['recipients as total_recipients'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('email.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('email.campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'video_url' => 'required|url',
            'thumbnail_url' => 'required|url',
            'cta_url' => 'nullable|url',
            'cta_text' => 'nullable|string|max:255',
            'scheduled_at' => 'nullable|date|after:now',
            'recipients' => 'required|string',
        ]);

        $campaign = EmailCampaign::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'subject' => $request->subject,
            'body' => $request->body,
            'video_url' => $request->video_url,
            'thumbnail_url' => $request->thumbnail_url,
            'cta_url' => $request->cta_url,
            'cta_text' => $request->cta_text,
            'scheduled_at' => $request->scheduled_at,
            'status' => $request->scheduled_at ? 'scheduled' : 'sent',
            'template_data' => $request->input('template_data', []),
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
        if ($request->scheduled_at) {
            SendEmailCampaignJob::dispatch($campaign)->delay($campaign->scheduled_at);
        } else {
            SendEmailCampaignJob::dispatch($campaign);
        }

        return redirect()->route('email.campaigns.index')
            ->with('success', 'Campaign created successfully!');
    }

    public function show(EmailCampaign $campaign)
    {
        // $this->authorize('view', $campaign);

        $campaign->load('recipients');
        
        $stats = [
            'total_recipients' => $campaign->recipients->count(),
            'opened' => $campaign->recipients->whereNotNull('opened_at')->count(),
            'viewed' => $campaign->recipients->whereNotNull('viewed_at')->count(),
            'clicked' => $campaign->recipients->whereNotNull('clicked_at')->count(),
        ];
        // Count total replies for this campaign
        $totalReplies = EmailReply::whereIn('email_recipient_id', $campaign->recipients->pluck('id'))->count();
        // Get reply counts for each recipient
        $recipientReplyCounts = $campaign->recipients->mapWithKeys(function($recipient) {
            return [$recipient->id => $recipient->replies()->count()];
        });
        return view('email.campaigns.show', compact('campaign', 'stats', 'totalReplies', 'recipientReplyCounts'));
    }

    public function edit(EmailCampaign $campaign)
    {
        // $this->authorize('update', $campaign);
        
        $campaign->load('recipients');
        $recipients = $campaign->recipients->pluck('email')->implode(', ');
        
        return view('email.campaigns.edit', compact('campaign', 'recipients'));
    }

    public function update(Request $request, EmailCampaign $campaign)
    {
        // $this->authorize('update', $campaign);

        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'video_url' => 'required|url',
            'thumbnail_url' => 'required|url',
            'cta_url' => 'nullable|url',
            'cta_text' => 'nullable|string|max:255',
            'scheduled_at' => 'nullable|date|after:now',
            'recipients' => 'required|string',
        ]);

        $campaign->update([
            'title' => $request->title,
            'subject' => $request->subject,
            'body' => $request->body,
            'video_url' => $request->video_url,
            'thumbnail_url' => $request->thumbnail_url,
            'cta_url' => $request->cta_url,
            'cta_text' => $request->cta_text,
            'scheduled_at' => $request->scheduled_at,
            'status' => $request->scheduled_at ? 'scheduled' : 'draft',
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

        return redirect()->route('email.campaigns.index')
            ->with('success', 'Campaign updated successfully!');
    }

    public function destroy(EmailCampaign $campaign)
    {
        // $this->authorize('delete', $campaign);
        
        $campaign->delete();
        
        return redirect()->route('email.campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }

    public function preview(EmailCampaign $campaign)
    {
        // $this->authorize('view', $campaign);
        
        return view('email.campaigns.preview', compact('campaign'));
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
        $templateView = 'email.campaigns.templates.' . $campaign->template;
        
        return view($templateView, [
            'campaign' => $campaign,
            'recipient' => $dummyRecipient,
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
        
        return view('email.campaigns.templates', compact('campaign'));
    }

    public function templatePreview(EmailCampaign $campaign, $template)
    {
        // $this->authorize('view', $campaign);
        
        $validTemplates = ['classic', 'modern', 'minimalist', 'bold', 'newsletter', 'custom'];
        
        if (!in_array($template, $validTemplates)) {
            return redirect()->route('email.campaigns.templates', $campaign)
                ->with('error', 'Invalid template selected!');
        }
        
        return view('email.campaigns.template-preview', compact('campaign', 'template'));
    }

    public function templatePreviewIframe(EmailCampaign $campaign, $template)
    {
        // $this->authorize('view', $campaign);
        
        $validTemplates = ['classic', 'modern', 'minimalist', 'bold', 'newsletter', 'custom'];
        
        if (!in_array($template, $validTemplates)) {
            abort(404);
        }
        
        // Create a dummy recipient for preview purposes
        $dummyRecipient = new EmailRecipient([
            'email_campaign_id' => $campaign->id,
            'email' => 'preview@example.com',
            'uuid' => (string) Str::uuid(),
        ]);
        
        // Use the specific template view
        $templateView = 'email.campaigns.templates.' . $template;
        
        return view($templateView, [
            'campaign' => $campaign,
            'recipient' => $dummyRecipient,
            'trackingPixel' => '#',
            'viewUrl' => $campaign->video_url,
            'clickUrl' => $campaign->cta_url,
        ]);
    }

    public function applyTemplate(Request $request, EmailCampaign $campaign)
    {
        // $this->authorize('update', $campaign);
        
        $request->validate([
            'template' => 'required|string|in:classic,modern,minimalist,bold,newsletter,custom',
        ]);

        $campaign->update(['template' => $request->template]);
        
        return redirect()->route('email.campaigns.show', $campaign)
            ->with('success', 'Template applied successfully!');
    }
} 