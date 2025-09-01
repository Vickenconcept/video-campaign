<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand_name',
        'address',
        'phone',
        'website',
        'email',
        'logo_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the display name for the brand
     */
    public function getDisplayNameAttribute()
    {
        return $this->brand_name ?: 'Video Campaign';
    }

    /**
     * Get the contact information as a formatted string
     */
    public function getContactInfoAttribute()
    {
        $info = [];
        
        if ($this->phone) {
            $info[] = "Phone: " . $this->phone;
        }
        
        if ($this->email) {
            $info[] = "Email: " . $this->email;
        }
        
        if ($this->website) {
            $info[] = "Website: " . $this->website;
        }
        
        if ($this->address) {
            $info[] = "Address: " . $this->address;
        }
        
        return implode("\n", $info);
    }
}
