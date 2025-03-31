<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];


    public function folder(){
        return $this->hasMany(Folder::class);
    }
    public function steps(){
        return $this->hasMany(Step::class);
    }
}
