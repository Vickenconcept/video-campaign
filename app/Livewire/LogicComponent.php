<?php

namespace App\Livewire;

use Livewire\Component;

class LogicComponent extends Component
{


    public $activeStep;
    public $multi_choice_question;
    // public $contact_detail, $formFields;

    public function mount($activeStep)
    {
        $this->activeStep = $activeStep;

        if ($this->activeStep !== null) {
            $this->multi_choice_question = json_decode($activeStep->multi_choice_question, true) ?? [];
        }
       
    }

    public function setNextStep($index, $position) {
        
        if ($this->activeStep !== null) {
            
            $options = $this->multi_choice_question;
            
            $options[$index] = $position;

          
            $this->activeStep->update([
                'multi_choice_question' => json_encode($options)
            ]);

            $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
            // $this->activeStep = $this->activeStep;
            $this->multi_choice_question = json_decode($this->activeStep->multi_choice_question, true);
        }
    }

    public function render()
    {
        return view('livewire.logic-component');
    }
}
