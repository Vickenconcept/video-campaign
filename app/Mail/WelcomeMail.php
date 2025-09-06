<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $password;
    public $brandSettings;
    public function __construct($password, $user = null)
    {
        $this->password = $password;
        $this->brandSettings = $user ? $user->getBrandSettings() : null;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
         // Use brand settings for the "From" name if available and active
         $fromName = '';
        
         if ($this->brandSettings && $this->brandSettings->is_active) {
             $fromName = $this->brandSettings->display_name ?: config('mail.from.address');
         }
 

        return new Envelope(
            subject: '🎉 Welcome to Video Campaign - Your Account is Ready!',
            from: new Address(config('mail.from.address'), $fromName),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        $brandSettings = null;
        if(auth()->check()){
            $brandSettings = auth()->user()->getBrandSettings();
        }

        return new Content(
            view: 'emails.welcome_email',
            with: [
                'password' => $this->password,
                'brandSettings' => $brandSettings, // Will use default branding for welcome emails    
            ],
        );
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}