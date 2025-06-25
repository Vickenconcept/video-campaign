<?php

namespace App\Jobs;

use App\Models\EmailCampaign;
use App\Models\EmailRecipient;
use App\Mail\VideoEmailCampaignMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign;

    public function __construct(EmailCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle()
    {
        $recipients = $this->campaign->recipients;

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)
                    ->send(new VideoEmailCampaignMailable($this->campaign, $recipient));
            } catch (\Exception $e) {
                // Log error but continue with other recipients
                Log::error('Failed to send email campaign', [
                    'campaign_id' => $this->campaign->id,
                    'recipient_email' => $recipient->email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Update campaign status to sent
        $this->campaign->update(['status' => 'sent']);
    }
} 