<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class MultiChoice extends Component
{

    public $activeStep;

    public $inputs, $settings;

    #[Validate('required', message: 'Please fill field first')]
    public $newKey = '';

    public function mount($activeStep = null)
    {
        $this->activeStep = $activeStep;
        $this->inputs = json_decode($this->activeStep->multi_choice_question, true) ?? [];
        $this->settings = json_decode($this->activeStep->multi_choice_setting, true) ?? [];
    }


    public function addInput()
    {
        $this->validate([
            'newKey' => 'required|string|not_in:' . implode(',', array_keys($this->inputs))
        ]);

        $this->inputs[$this->newKey] = 1;
        $this->newKey = '';
        $this->saveOptions();
    }

    public function removeInput($key)
    {
        if (array_key_exists($key, $this->inputs)) {
            unset($this->inputs[$key]);
        }
        $this->saveOptions();
    }

    public function saveOptions()
    {
        $this->activeStep->update([
            'multi_choice_question' => json_encode($this->inputs)
        ]);

        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');

    }

    public function toggleSettingStatus($index)
    {
        if ($this->activeStep !== null) {

            $settings = $this->settings;

            if ($settings[$index]['status']) {
                $settings[$index]['status'] = true;
            } else {
                $settings[$index]['status'] = false;
            }

            $this->activeStep->update([
                'multi_choice_setting' => json_encode($settings)
            ]);

        }
    }


    public function render()
    {
        return view('livewire.multi-choice');
    }
}
