<?php

namespace App\Livewire;

use Livewire\Component;

class CalenderComponent extends Component
{

    public $activeStep, $calender_link;

    public function mount($activeStep)
    {
        $this->activeStep = $activeStep;
        if ($this->activeStep->calender_link == null) {
            $this->activeStep->update(['calender_link' => 'https://calendly.com/videoaskteam/30min']);
        }
        $this->calender_link = optional($this->activeStep)->calender_link ?? 'https://calendly.com/videoaskteam/30min';
    }

    public function saveCalenderLink()
    {
        $this->activeStep->update(['calender_link' => trim($this->calender_link)]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    public function render()
    {
        return view('livewire.calender-component');
    }
}
