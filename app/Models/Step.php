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
        'previous' => 'array',
        'file_type' => 'array',
    ];
    
    public function getNextStep($action)
    {
        $multi_choice_question = json_decode($this->multi_choice_question, true);
        return $multi_choice_question[$action]; 
    }
    public function getPreviousStep($action)
    {
        $previous = json_decode($this->previous, true);
        return $previous[$action]; 
    }
    
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }
}
