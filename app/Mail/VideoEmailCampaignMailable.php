<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use App\Models\EmailRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VideoEmailCampaignMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    public $recipient;

    public function __construct(EmailCampaign $campaign, EmailRecipient $recipient)
    {
        $this->campaign = $campaign;
        $this->recipient = $recipient;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->campaign->subject,
        );
    }

    public function content(): Content
    {
        $templateView = "";
        if ($this->campaign->type == 'video_email') {
            $templateView = 'email.campaigns.templates.' . $this->campaign->template;
        }
        else{
            $templateView = 'video_page.campaigns.templates.' . $this->campaign->template;
        }
        
        return new Content(
            view: $templateView,
            with: [
                'campaign' => $this->campaign,
                'recipient' => $this->recipient,
                'trackingPixel' => route('email.tracking.open', ['r' => $this->recipient->uuid]),
                'viewUrl' => route('email.tracking.view', ['r' => $this->recipient->uuid]),
                'clickUrl' => $this->campaign->cta_url ? route('email.tracking.click', [
                    'r' => $this->recipient->uuid,
                    'url' => $this->campaign->cta_url
                ]) : null,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
} 