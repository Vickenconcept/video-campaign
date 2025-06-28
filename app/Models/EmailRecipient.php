<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class EmailRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_campaign_id',
        'email',
        'opened_at',
        'viewed_at',
        'clicked_at',
        'uuid',
    ];

    protected $dates = [
        'opened_at',
        'viewed_at',
        'clicked_at',
    ];

    public function campaign()
    {
        return $this->belongsTo(EmailCampaign::class, 'email_campaign_id');
    }

    public function replies()
    {
        // return $this->hasMany(EmailReply::class);
        return $this->hasMany(EmailReply::class, 'email_recipient_id', 'uuid');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
} 