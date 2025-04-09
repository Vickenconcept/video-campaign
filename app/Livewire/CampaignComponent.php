<?php

namespace App\Livewire;

use App\Models\Campaign;
use App\Models\Step;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class CampaignComponent extends Component
{

    public $campaign, $steps, $activeStep, $activeName, $user, $form, $multi_choice_setting;
    public $id, $postion, $contact_detail = false;

    public $activeTab = 'answer';
    public $answer_type = 'open_ended';

    public function mount($uuid)
    {
        $this->campaign = Campaign::where('uuid', $uuid)->firstOrFail();
        $this->steps = $this->campaign->steps;

        $this->user = auth()->user();

        $this->form = json_encode([
            ['name' => 'name', 'label' => 'name', 'type' => 'text', 'required' => false, 'active' => true],
            ['name' => 'email', 'label' => 'email', 'type' => 'email', 'required' => true, 'active' => true],
            ['name' => 'phonenumber', 'label' => 'phone number', 'type' => 'tel', 'required' => false, 'active' => false],
            ['name' => 'productname', 'label' => 'product name', 'type' => 'text', 'required' => false, 'active' => false],
            ['name' => 'consent', 'label' => 'ask for consent', 'type' => 'checkbox', 'required' => false, 'active' => false],
            ['name' => 'additionaltext', 'label' => 'additional text', 'type' => 'null', 'required' => false, 'active' => false],
        ]);

        $this->multi_choice_setting = json_encode([
            ['name' => 'multiple_select', 'label' => 'Enable multiple selection','status' => false, 'info' => 'Allow multiple selection of multiple choice items.'],
            ['name' => 'randomize', 'label' => 'Randomize','status' => false, 'info' => 'Change the oder of your choices everytime your campaign is viewed'],
            ['name' => 'skip_data_collection', 'label' => 'Skip data collection','status' => false, 'info' => 'use this setting if you are using multiple choice for navigation only as to skip collection of data'],
            ['name' => 'option_count', 'label' => 'Show option count','status' => false, 'info' => 'Display help text above multiple choice options showing the number of options available to select'],
        ]);

        
    }

    public function goToTab($tab)
    {
        $this->activeTab = $tab;
    }

    // public function addStep($position)
    // {
    //     $newPosition = $position + 1;

    //     $steps = $this->campaign->steps()->orderBy('position')->get();

    //     foreach ($steps as $step) {
    //         if ($step->position >= $newPosition) {
    //             $step->update(['position' => $step->position + 1]);
    //         }
    //     }

    //     $this->campaign->steps()->create([
    //         'uuid' => Str::uuid(),
    //         'name' => "Step $newPosition",
    //         'position' => $newPosition,
    //         'contact_detail' => $this->contact_detail,
    //     ]);

    //     $this->steps = $this->campaign->steps;
    //     session()->flash('success', 'Step added successfully.');
    // }

    public function updateAnswerType() {

        $multi_choice_question = $this->answer_type !== 'multi_choice' ? json_encode(['default' => 1]): null;

        $this->activeStep->update([
            'answer_type' =>  $this->answer_type,
            'multi_choice_question' =>  $multi_choice_question
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
    }

    #[On('update-contact-detail')]
    public function update_contact_detail($tab)
    {
        $this->activeTab = $tab;
    }
    #[On('update-video')]
    public function update_video($url)
    {
        $this->activeStep->update([
            'video_url' =>  $url,
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');
        // $this->activeTab = $tab;
    }


    public function addStep($position)
    {
        $newPosition = $position + 1;

        $steps = $this->campaign->steps()->orderBy('position')->get();
        foreach ($steps as $step) {
            if ($step->position >= $newPosition) {
                $step->update(['position' => $step->position + 1]);
            }
        }
        $multi_choice_question = json_encode(['default' => 1]);
        $video_setting = json_encode(['position' => 'top', 'fit' => true, 'overlay_text' => '', 'text_size' => 'text-sm' , 'overlay_bg' => true]);

        // Create the new step
        $newStep = $this->campaign->steps()->create([
            'uuid' => Str::uuid(),
            'name' => "default Step",
            'position' => $newPosition,
            'contact_detail' => $this->contact_detail,
            'form' => $this->form,
            'multi_choice_setting' => $this->multi_choice_setting,
            'multi_choice_question' => $multi_choice_question,
            'video_setting' => $video_setting,
        ]);
        
        $this->steps = $this->campaign->steps;

        session()->flash('success', 'Step added successfully.');
    }


    public function goToNextStep($stepId, $action)
    {
        $step = Step::find($stepId);
        $nextStepId = $step->getNextStep($action);

        if ($nextStepId) {
            return redirect()->route('campaign.show', ['uuid' => Step::find($nextStepId)->uuid]);
        } else {
            session()->flash('error', 'No step found for this action.');
            return back();
        }
    }



    public function rearrangeStep($currentPosition, $targetPosition)
    {
        if ($currentPosition == $targetPosition) {
            return;
        }

        $steps = $this->campaign->steps()->orderBy('position')->get();

        $movingStep = $steps->firstWhere('position', $currentPosition);

        if (!$movingStep) {
            return;
        }

        // Shift positions for affected steps
        foreach ($steps as $step) {
            if ($currentPosition < $targetPosition) {
                // Moving Down: Shift steps up
                if ($step->position > $currentPosition && $step->position <= $targetPosition) {
                    $step->update(['position' => $step->position - 1]);
                }
            } else {
                // Moving Up: Shift steps down
                if ($step->position >= $targetPosition && $step->position < $currentPosition) {
                    $step->update(['position' => $step->position + 1]);
                }
            }
        }

        $movingStep->update(['position' => $targetPosition]);
        $this->steps = $this->campaign->steps;

        session()->flash('success', 'Steps rearranged successfully.');
    }

    public function duplicateStep($stepId)
    {
        $step = $this->campaign->steps()->find($stepId);

        if (!$step) {
            return;
        }

        $lastPosition = $this->campaign->steps()->max('position');

        // Create a new duplicated step
        $newStep = $this->campaign->steps()->create([
            'uuid' => Str::uuid(),
            'name' => $step->name . ' (Copy)',
            'position' => $lastPosition + 1,
            'contact_detail' => $step->contact_detail,
            'form' => $this->form,
            'multi_choice_setting' => $this->multi_choice_setting,
        ]);

        $this->steps = $this->campaign->steps;

        session()->flash('success', 'Step duplicated successfully.');
    }


    public function deleteStep($id, $position)
    {
        $this->campaign->steps()->where('id', $id)->delete();

        $steps = $this->campaign->steps()->where('position', '>', $position)
            ->orderBy('position')
            ->get();

        foreach ($steps as $step) {
            $step->update(['position' => $step->position - 1]);
        }

        $this->steps = $this->campaign->steps;
        session()->flash('success', 'Step deleted and reordered successfully.');
    }

    public function saveStepName(){

        $this->activeStep->update([
            'name' =>  $this->activeName,
        ]);

        $this->steps = $this->campaign->steps;

        $this->dispatch('notify', status: 'success', msg: 'Saved successfully!');

    }


    public function setStep($id, $postion)
    {
        $this->id = $id;
        $this->postion = $postion;

        $this->activeStep = $this->campaign->steps()
            ->where('id', $this->id)
            ->first();

            $this->activeName = $this->activeStep->name ?? '';

        $this->answer_type = $this->activeStep->answer_type;
        // dd($this->activeStep);
    }

    public function render()
    {
        return view('livewire.campaign-component')->layout('layouts.app');
    }
}
