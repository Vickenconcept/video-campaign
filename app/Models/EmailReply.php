<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_recipient_id',
        'message',
        'sender_name',
        'sender_email',
    ];

    public function recipient()
    {
        return $this->belongsTo(EmailRecipient::class, 'email_recipient_id', 'uuid');
    }

    public function campaign()
    {
        return $this->recipient ? $this->recipient->campaign : null;
    }
} 