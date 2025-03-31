<?php

namespace App\Livewire;

use App\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;

class FolderComponent extends Component
{

    use WithPagination;
    public $search, $sortOrder;

    // Livewire will automatically pass the parameter here
    public function mount()
    {
    }
    
    public function render()
    {

        $folders = Folder::with('campaigns');  

        if ($this->search) {
            $folders->where("name", 'like', '%' . $this->search . '%');
            dd('jjjj');
        }

        if ($this->sortOrder === 'latest') {
            $folders->latest();  
        } elseif ($this->sortOrder === 'oldest') {
            $folders->oldest();  
        }

        $folders = $folders->paginate(9);

        
        return view('livewire.folder-component', compact('folders'))->layout('layouts.app');
    }
}
