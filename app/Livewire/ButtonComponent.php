<?php

namespace App\Livewire;

use Livewire\Component;

class ButtonComponent extends Component
{

    public $activeStep, $button_component;

    public function mount($activeStep)
    {
        $this->activeStep = $activeStep;
        $this->button_component = optional($this->activeStep)->button_component;

    }

    public function saveButtonComponent()
    {
        $this->activeStep->update(['button_component' => $this->button_component]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }
    public function render()
    {
        return view('livewire.button-component');
    }
}
