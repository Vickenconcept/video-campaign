<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'video_setting' => 'array',
        'form' => 'array',
        'multi_choice_question' => 'array',
        'multi_choice_setting' => 'array',
    ];
    
    public function getNextStep($action)
    {
        return $this->multi_choice_question[$action] ?? null; // Get step ID based on action
    }
    
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }
}
