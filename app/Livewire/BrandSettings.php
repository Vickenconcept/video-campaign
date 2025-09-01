<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\BrandSettings as BrandSettingsModel;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary;

class BrandSettings extends Component
{
    use WithFileUploads;

    public $brand_name;
    public $address;
    public $phone;
    public $website;
    public $email;
    public $logo;
    public $is_active = true;

    public $logo_url;
    public $showPreview = false;

    protected $rules = [
        'brand_name' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:500',
        'phone' => 'nullable|string|max:20',
        'website' => 'nullable|url|max:255',
        'email' => 'nullable|email|max:255',
        'logo' => 'nullable|image|max:2048', // 2MB max
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $user = Auth::user();
        $brandSettings = $user->getBrandSettings();

        $this->brand_name = $brandSettings->brand_name;
        $this->address = $brandSettings->address;
        $this->phone = $brandSettings->phone;
        $this->website = $brandSettings->website;
        $this->email = $brandSettings->email;
        $this->logo_url = $brandSettings->logo_url;
        $this->is_active = $brandSettings->is_active;
    }

    public function updatedLogo()
    {
        $this->validate([
            'logo' => 'image|max:2048',
        ]);
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $brandSettings = $user->getBrandSettings();

        // Handle logo upload to Cloudinary
        if ($this->logo) {
            $cloudinary = new Cloudinary();
            $cloudinaryResponse = $cloudinary->uploadApi()->upload($this->logo->getRealPath(), [
                'resource_type' => 'image',
                'folder' => 'brand-logos',
            ]);
            $this->logo_url = $cloudinaryResponse['secure_url'];
        }

        $brandSettings->update([
            'brand_name' => $this->brand_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'website' => $this->website,
            'email' => $this->email,
            'logo_url' => $this->logo_url,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Brand settings updated successfully!');
    }

    public function togglePreview()
    {
        $this->showPreview = !$this->showPreview;
    }

    public function render()
    {
        return view('livewire.brand-settings')->layout('layouts.app');
    }
}
