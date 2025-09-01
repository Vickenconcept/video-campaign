<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use App\Models\BrandSettings;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function folders(){
        return $this->hasMany(Folder::class);
    }

    public function resellers()
    {
        return $this->hasMany(Reseller::class);
    }

    public function brandSettings()
    {
        return $this->hasOne(BrandSettings::class);
    }

    /**
     * Get the user's brand settings or create default ones
     */
    public function getBrandSettings()
    {
        $brandSettings = $this->brandSettings()->first();
        
        if (!$brandSettings) {
            $brandSettings = $this->brandSettings()->create([
                'brand_name' => null,
                'company_name' => null,
                'address' => null,
                'phone' => null,
                'website' => null,
                'email' => $this->email,
                'logo_url' => null,
                'is_active' => true,
            ]);
        }
        
        return $brandSettings;
    }
}
