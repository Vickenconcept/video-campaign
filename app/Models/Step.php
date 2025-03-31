<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    //
    protected $guarded = [];
    
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }
}
