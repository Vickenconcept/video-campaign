<?php

namespace App\Livewire;

use Livewire\Component;

class OpenEnded extends Component
{
    public $activeStep;
    public $allow_video_response, $allow_text_response, $allow_audio_response;

    public function mount($activeStep)
    {
        $this->activeStep = $activeStep;
        $this->allow_video_response =  optional($this->activeStep)->allow_video_response ? true: false;
        $this->allow_text_response = optional($this->activeStep)->allow_text_response ? true: false;
        $this->allow_audio_response = optional($this->activeStep)->allow_audio_response ? true: false;
    }

    public function update_video_response()
    {
        !$this->allow_video_response ? $this->activeStep->update(['allow_video_response' => false]) : $this->activeStep->update(['allow_video_response' => true]);
    }

    public function update_text_response()
    {
        !$this->allow_text_response ? $this->activeStep->update(['allow_text_response' => false]) : $this->activeStep->update(['allow_text_response' => true]);
    }


    public function update_audio_response()
    {
        !$this->allow_audio_response ? $this->activeStep->update(['allow_audio_response' => false]) : $this->activeStep->update(['allow_audio_response' => true]);
    }

    public function render()
    {
        return view('livewire.open-ended');
    }
}
