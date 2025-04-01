<?php

namespace App\Livewire;

use App\Models\Folder;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class FolderShowComponent extends Component
{
    public $folder, $campaigns;
    public $user;

    #[Validate('required', message: 'Please provide a campaign title')]
    public $title;
    public $contact_detail = true, $language = 'en';

    // Livewire will automatically pass the parameter here
    public function mount($uuid)
    {
        $this->folder = Folder::where('uuid', $uuid)->firstOrFail();
        $this->campaigns = $this->folder->campaigns;

        $this->user = auth()->user();
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
            ['name' => 'multiple_select', 'label' => 'Enable multiple selection','status' => false, 'info' => 'Allow multiple selection of multiple choice items.'],
            ['name' => 'randomize', 'label' => 'Randomize','status' => false, 'info' => 'Change the oder of your choices everytime your campaign is viewed'],
            ['name' => 'skip_data_collection', 'label' => 'Skip data collection','status' => false, 'info' => 'use this setting if you are using multiple choice for navigation only as to skip collection of data'],
            ['name' => 'option_count', 'label' => 'Show option count','status' => false, 'info' => 'Display help text above multiple choice options showing the number of options available to select'],
        ]);
        
        $campaign->steps()->create([
            'uuid' => Str::uuid(),
            'name' => 'step 1',
            'position' => 1,
            'contact_detail' => $this->contact_detail,
            'form' => $form,
            'multi_choice_setting' => $multi_choice_setting,
            
        ]);

        session()->flash('success', 'Campaign successfully created.');

        return redirect()->route('campaign.show', ['uuid' => $campaign->uuid]);

    }




    public function render()
    {
        return view('livewire.folder-show-component')->layout('layouts.app');
    }
}
