<?php

namespace App\Livewire;

use Livewire\Component;

class TimerComponent extends Component
{
    public $activeStep;
    public $start_time;
    public $end_time;
    public $cta_url;
    public $cta_text;
    public $additional_text;

    public function mount($activeStep = null)
    {
        $this->activeStep = $activeStep;
        $timer = json_decode($this->activeStep->timer_setting, true) ?? [];
        $this->start_time = $timer['start_time'] ?? '';
        $this->end_time = $timer['end_time'] ?? '';
        $this->cta_url = $timer['cta_url'] ?? '';
        $this->cta_text = $timer['cta_text'] ?? 'Go to';
        $this->additional_text = $timer['additional_text'] ?? '';
    }

    public function saveTimer()
    {
        $timer = [
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'cta_url' => $this->cta_url,
            'cta_text' => $this->cta_text,
            'additional_text' => $this->additional_text,
        ];
        $this->activeStep->update([
            'timer_setting' => json_encode($timer)
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Timer settings saved!');
    }

    public function render()
    {
        return view('livewire.timer-component');
    }
} 