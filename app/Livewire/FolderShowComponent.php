<?php

namespace App\Livewire;

use App\Models\Folder;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class FolderShowComponent extends Component
{
    public $folder, $all_folder, $campaigns, $campaignID;
    public $user, $selectedFolder;

    #[Validate('required', message: 'Please provide a campaign title')]
    public $title;
    public $contact_detail = true, $language = 'en';

    // Livewire will automatically pass the parameter here
    public function mount($uuid)
    {
        $this->folder = Folder::where('uuid', $uuid)->firstOrFail();
        $this->all_folder = Folder::latest()->get();
        $this->campaigns = $this->folder->campaigns;

        $this->user = auth()->user();
    }


    public function setCampaign($id)
    {

        $this->campaignID = $id;

        if ($this->campaignID) {
            $campaign = $this->campaigns->find($this->campaignID);

            $this->title =  $campaign->title;
            $this->language = $campaign->language;
        }
    }
    public function deleteCampaign()
    {
        if ($this->campaignID) {
            $this->campaigns->find($this->campaignID)->delete();
        }
        $this->campaigns = $this->folder->campaigns;

        $this->title = '';
        $this->language = '';
        $this->dispatch('notify', status: 'success', msg: 'Deleted successfully!');
    }



    public function createCampaign()
    {
        $this->validate([
            'title' => 'required',
        ]);

        $campaign = $this->folder->campaigns()->create([
            'uuid' => Str::uuid(),
            'title' => $this->title,
            'language' => $this->language
        ]);

        $form = json_encode([
            ['name' => 'name', 'label' => 'name', 'type' => 'text', 'required' => false, 'active' => true],
            ['name' => 'email', 'label' => 'email', 'type' => 'email', 'required' => true, 'active' => true],
            ['name' => 'phonenumber', 'label' => 'phone number', 'type' => 'tel', 'required' => false, 'active' => false],
            ['name' => 'productname', 'label' => 'product name', 'type' => 'text', 'required' => false, 'active' => false],
            ['name' => 'consent', 'label' => 'ask for consent', 'type' => 'checkbox', 'required' => false, 'active' => false],
            ['name' => 'additionaltext', 'label' => 'additional text', 'type' => 'null', 'required' => false, 'active' => false],
        ]);

        $multi_choice_setting = json_encode([
            ['name' => 'multiple_select', 'label' => 'Enable multiple selection', 'status' => false, 'info' => 'Allow multiple selection of multiple choice items.'],
            ['name' => 'randomize', 'label' => 'Randomize', 'status' => false, 'info' => 'Change the oder of your choices everytime your campaign is viewed'],
            ['name' => 'skip_data_collection', 'label' => 'Skip data collection', 'status' => false, 'info' => 'use this setting if you are using multiple choice for navigation only as to skip collection of data'],
            ['name' => 'option_count', 'label' => 'Show option count', 'status' => false, 'info' => 'Display help text above multiple choice options showing the number of options available to select'],
        ]);

        $video_setting = json_encode(['position' => 'top', 'fit' => true, 'overlay_text' => '', 'text_size' => 'text-sm', 'overlay_bg' => true]);

        $multi_choice_question = json_encode(['default' => 1]);

        $campaign->steps()->create([
            'uuid' => Str::uuid(),
            'name' => 'step 1',
            'position' => 1,
            'contact_detail' => $this->contact_detail,
            'form' => $form,
            'multi_choice_setting' => $multi_choice_setting,
            'multi_choice_question' => $multi_choice_question,
            'video_setting' => $video_setting,

        ]);

        // $campaign->steps()->create([
        //     'uuid' => Str::uuid(),
        //     'name' => 'step 1',
        //     'position' => 0,
        //     'form' => $form,
        //     'multi_choice_setting' => $multi_choice_setting,
        //     'multi_choice_question' => $multi_choice_question,
        //     'video_setting' => $video_setting,

        // ]);

        session()->flash('success', 'Campaign successfully created.');

        return redirect()->route('campaign.show', ['uuid' => $campaign->uuid]);
    }


    public function duplicateCampaign($id)
    {
        $originalCampaign = $this->campaigns->find($id);

        if (!$originalCampaign) {
            return;
        }

        $newCampaign = $originalCampaign->replicate();
        $newCampaign->title = $originalCampaign->title . ' (Copy)';
        $newCampaign->uuid = Str::uuid();
        $newCampaign->push();

        foreach ($originalCampaign->steps as $step) {
            $newStep = $step->replicate();
            $newStep->campaign_id = $newCampaign->id;
            $newStep->save();
        }

        $this->campaigns = $this->folder->campaigns;
        $this->dispatch('notify', status: 'success', msg: 'Duplicated successfully!');
    }

    public function moveToFolder()
    {
        if ($this->campaignID) {
            $campaign = $this->campaigns->find($this->campaignID);

            if ($campaign) {
                $campaign->update([
                    'folder_id' => $this->selectedFolder
                ]);
            }

            $this->campaigns = $this->folder->campaigns;
            $this->dispatch('notify', status: 'success', msg: 'Moved successfully!');
        }
    }

    public function editCampaign()
    {
        if ($this->campaignID) {
            $campaign = $this->campaigns->find($this->campaignID);

            if ($campaign) {
                $campaign->update([
                    'title' => $this->title,
                    'language' => $this->language,
                ]);
            }

            $this->campaigns = $this->folder->campaigns;
            $this->dispatch('notify', status: 'success', msg: 'Updated successfully!');
        }
    }


    public function render()
    {
        return view('livewire.folder-show-component')->layout('layouts.app');
    }
}
