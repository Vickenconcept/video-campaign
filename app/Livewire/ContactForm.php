<?php

namespace App\Livewire;

use Livewire\Component;

class ContactForm extends Component
{

    public $activeStep;
    public $activeTab;
    public $contact_detail, $formFields;

    public function mount($activeStep = null, $activeTab)
    {
        $this->activeStep = $activeStep;
        $this->contact_detail = optional($this->activeStep)->contact_detail ? true : false;
        $this->activeTab = $activeTab;
        if ($this->activeStep !== null) {
            $this->formFields = json_decode($activeStep->form, true);
        }
    }
    public function update_contact_detail()
    {
        !$this->contact_detail ? $this->activeStep->update(['contact_detail' => false]) : $this->activeStep->update(['contact_detail' => true]);
    }

    public function update_active_tab()
    {

        $this->dispatch('update-contact-detail', tab: 'contactForm');
    }


    public function toggleFieldActive($index)
    {
        if ($this->activeStep !== null) {

            $form = $this->formFields;

            $form[$index]['active'] = !$form[$index]['active'];

            if (!$form[$index]['active']) {
                $form[$index]['required'] = false;
            }
            $this->activeStep->update([
                'form' => json_encode($form)
            ]);

            $this->formFields = json_decode($this->activeStep->form, true);
        }
    }

    public function toggleFieldRequired($index)
    {
        if ($this->activeStep !== null) {
            $form = $this->formFields;

            if ($form[$index]['active']) {
                $form[$index]['required'] = !$form[$index]['required'];
            }

            $this->activeStep->update([
                'form' => json_encode($form)
            ]);

        }
        $this->formFields = json_decode($this->activeStep->form, true);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
