<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendRawMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $mailBody;

    public function __construct($email, $mailBody)
    {
        $this->email = $email;
        $this->mailBody = $mailBody;
    }

    public function handle()
    {
        Mail::raw($this->mailBody, function ($msg) {
            $msg->to($this->email)
                ->subject('Action Required');
        });
    }
}
