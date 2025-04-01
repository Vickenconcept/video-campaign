<?php

namespace App\Livewire;

use App\Models\Folder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class FolderComponent extends Component
{

    use WithPagination;
    public $search, $sortOrder;

    #[Validate('required', message: 'Please provide a folder name')]
    public $name;
    public $id;
    public $description;
    public $user;

    public function mount() {
        $this->user = auth()->user();
    }

    public function setFolder($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function createFolder()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $this->user->folders()->create([
            'uuid' => Str::uuid(),
            'name' => $this->name,
            'description' => $this->description
        ]);
        session()->flash('success', 'Folder successfully created.');

        $this->redirect('/folder');
    }
    

    public function updateFolder() {

        $this->validate([
            'name' => 'required',
        ]);

        $this->user->folders()->where('id', $this->id)->update([
            'name' => $this->name,
        ]);
        session()->flash('success', 'Folder successfully updated.');

        $this->redirect('/folder');
    }

    public function deleteForm()
    {
        if ($this->id) {
            $this->user->folders()->where('id', $this->id)->delete();
            session()->flash('success', 'Folder successfully updated.');
    
            $this->redirect('/folder');
        }
    }

    public function render()
    {

        $folders = Folder::with('campaigns');

        if ($this->search) {
            $folders->where("name", 'like', '%' . $this->search . '%');
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
