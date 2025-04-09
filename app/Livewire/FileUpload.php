<?php

namespace App\Livewire;

use Livewire\Component;

class FileUpload extends Component
{
    public $activeStep, $file_type;

    public function mount($activeStep)
    {
        $this->activeStep = $activeStep;
        $this->file_type = json_decode(optional($this->activeStep)->file_type, true) ?? [];

    }

    public function saveFileType()
    {
        // dd($this->file_type);
        $this->activeStep->update(['file_type' => json_encode($this->file_type)]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}
