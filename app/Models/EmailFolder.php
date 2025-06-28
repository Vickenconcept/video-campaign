<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaigns()
    {
        return $this->hasMany(EmailCampaign::class, 'email_folder_id');
    }

    public function campaignsCount()
    {
        return $this->campaigns()->count();
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y');
    }
} 