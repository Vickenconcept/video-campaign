<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\EmailRecipient;
use App\Models\EmailFolder;

class EmailCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_folder_id',
        'title',
        'subject',
        'body',
        'video_url',
        'thumbnail_url',
        'cta_url',
        'cta_text',
        'scheduled_at',
        'status',
        'template',
        'template_data',
        'type',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'template_data' => 'array',
    ];

    protected $attributes = [
        'template' => 'classic',
    ];

    public function recipients()
    {
        return $this->hasMany(EmailRecipient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(EmailFolder::class, 'email_folder_id');
    }
} 