<?php

namespace App\Livewire;

use App\Models\Folder;
use Livewire\Component;

class FolderShowComponent extends Component
{
    public $folder;

    // Livewire will automatically pass the parameter here
    public function mount($uuid)
    {
        $this->folder = Folder::where('uuid', $uuid)->firstOrFail();
    }

    
    public function render()
    {
        return view('livewire.folder-show-component')->layout('layouts.app');
    }
}
