<?php

namespace App\Livewire;

use App\Models\Campaign;
use Livewire\Component;

class ShowCampaign extends Component
{

    public $campaign,$steps;
    public $nextStep ;
    public $preview ;
    
    public function mount($uuid)
    {
        $this->campaign = Campaign::where('uuid', $uuid)->firstOrFail();

        $this->steps = $this->campaign->steps;
        
        $this->preview = request()->has('preview');
    }

    public function goToNext($id,$action){

        $step = $this->steps->findOrFail($id);
        
        $next = $step->getNextStep($action);
        $this->nextStep = $next;
    }

    public function render()
    {
        return view('livewire.show-campaign')->layout('layouts.guest');
    }
}
