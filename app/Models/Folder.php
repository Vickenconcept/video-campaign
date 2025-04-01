<?php

namespace App\Models;

use App\Models\Scopes\DataAccessScope;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function campaigns(){
        return $this->hasMany(Campaign::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DataAccessScope);

    }
}
