<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Models\EmailRecipient;
use App\Models\EmailReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TrackingController extends Controller
{
    public function open(Request $request)
    {
        $recipientId = $request->query('r');
        
        if ($recipientId) {
            $recipient = EmailRecipient::where('uuid', $recipientId)->first();
            
            if ($recipient && !$recipient->opened_at) {
                $recipient->update(['opened_at' => now()]);
            }
        }

        // Return a 1x1 transparent pixel
        $pixel = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
        
        return response($pixel, 200, [
            'Content-Type' => 'image/gif',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    public function view(Request $request)
    {
        $recipientId = $request->query('r');
        $recipient = null;
        if ($recipientId) {
            $recipient = EmailRecipient::where('uuid', $recipientId)->first();
            if ($recipient && !$recipient->viewed_at) {
                $recipient->update(['viewed_at' => now()]);
            }
        }
        $replies = $recipient ? $recipient->replies()->get() : collect();
        $isOwner = false;
        if (Auth::check() && $recipient && $recipient->campaign && $recipient->campaign->user_id === Auth::id()) {
            $isOwner = true;
        }
        return view('email.tracking.view', compact('recipient', 'replies', 'isOwner'));
    }

    public function click(Request $request)
    {
        $recipientId = $request->query('r');
        $url = $request->query('url');
        
        if ($recipientId) {
            $recipient = EmailRecipient::where('uuid', $recipientId)->first();
            
            if ($recipient && !$recipient->clicked_at) {
                $recipient->update(['clicked_at' => now()]);
            }
        }

        return redirect($url ?? '/');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'email_recipient_id' => 'required|exists:email_recipients,uuid',
            'message' => 'required|string',
            'sender_name' => 'nullable|string|max:255',
            'sender_email' => 'nullable|email|max:255',
        ]);
        $reply = EmailReply::create([
            'email_recipient_id' => $request->email_recipient_id,
            'message' => $request->message,
            'sender_name' => $request->sender_name,
            'sender_email' => $request->sender_email,
        ]);

        // If the admin is replying (sender is campaign owner), notify the user if their email is available
        $recipient = EmailRecipient::where('uuid', $request->email_recipient_id)->first();
        $campaign = $recipient ? $recipient->campaign : null;
        if ($campaign && Auth::check() && $campaign->user_id === Auth::id() && $recipient && $recipient->email) {
            // Only send if the original user provided an email
            if ($recipient->email) {
                $chatUrl = route('email.tracking.view', ['r' => $recipient->uuid]);
                Mail::raw("You have a new reply from the campaign creator. View the conversation: $chatUrl", function($msg) use ($recipient) {
                    $msg->to($recipient->email)
                        ->subject('You have a new reply to your video campaign message');
                });
            }
        }

        return redirect()->back()->with('reply_success', 'Reply sent successfully!');
    }
} 