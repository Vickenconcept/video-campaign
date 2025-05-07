<?php

namespace App\Livewire;

use App\Models\Campaign;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\On;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ShowCampaign extends Component
{
    use WithFileUploads;

    public $campaign, $steps,$lastStep;
    public $nextStep;
    public $preview;
    public $contactDetailShownStepId;
    public $userToken;
    public $paypal_keys;
    public $mediaID;
    public $selectedLang;


    public $videoResponse, $textResponse, $audioResponse, $NPSScore;
    public $activeForm;

    public $name, $email, $phonenumber, $productname, $consent, $additionaltext;
    public $selectedOptions = [];



    public function mount($uuid)
    {

        $currentUuid = Cache::get('user_uuid');
        $currentToken = Cache::get('user_token');

        if (!$currentUuid || $currentUuid !== $uuid) {
            $newToken = Str::uuid()->toString();
            Cache::put('user_uuid', $uuid, 180); // 3600 seconds
            Cache::put('user_token', $newToken, 180); // 3600 seconds

            $this->userToken = $newToken;
        } else {
            $this->userToken = $currentToken;
        }


        $this->campaign = Campaign::where('uuid', $uuid)->firstOrFail();
        $this->selectedLang =  $this->campaign->language;

        $this->steps = $this->campaign->steps;

        $this->lastStep = $this->steps->sortByDesc('id')->first();

        $this->preview = request()->has('preview');

        foreach ($this->steps as $step) {
            if ($step->contact_detail) {
                $this->contactDetailShownStepId = $step->id;
                break;
            }
        }

        $this->nextStep = $this->steps->min('id');

        $this->activeForm = json_decode($this->steps->findOrFail($this->nextStep)->form, true) ?? [];
    }


    public function getCanContinueProperty()
    {
        $form = $this->activeForm;
        foreach ($form as $field) {
            if ($field['active'] && $field['required']) {
                $value = trim($this->{$field['name']} ?? '');
                if ($field['type'] === 'checkbox') {
                    if (empty($this->{$field['name']})) {
                        return false;
                    }
                } elseif ($value === '') {
                    return false;
                }
            }
        }
        return true;
    }


    public function goToNext($id = 0, $action = 'defualt')
    {
        try {
            // [ everything inside goToNext as is... ]

            if (!$this->preview) {
                if (trim($this->textResponse) !== '') {
                    $this->saveText();
                } else {
                    session()->flash('error', 'Text response cannot be empty.');
                }


                # code...
                if (
                    (
                        !empty(trim($this->name)) ||
                        !empty(trim($this->email)) ||
                        !empty(trim($this->phonenumber)) ||
                        !empty(trim($this->productname)) ||
                        !empty(trim($this->consent)) ||
                        !empty(trim($this->additionaltext))
                    )
                ) {
                    $this->saveContact();
                }

                if (!empty($this->selectedOptions)) {
                    $this->saveSelectedOptions();
                }

                if (!empty($this->NPSScore)) {
                    $this->saveNPSScore();
                }
            }






            // =====================================
            // =====================================
            // =====================================

            $this->textResponse = '';

            $currentStep = $this->steps->findOrFail($id);

            $nextStepId = $currentStep->getNextStep($action);

            $nextStep = $this->steps->findOrFail($nextStepId);

            $previous = json_decode($nextStep->previous, true) ?? [];

            $previous = [$action => $id];

            $nextStep->update([
                'previous' => json_encode($previous),
            ]);



            $this->nextStep = $nextStepId;
            $this->activeForm = json_decode($nextStep->form, true);

            $this->paypal_keys = json_decode($this->campaign->paypal_keys, true);

            // dd($this->paypal_keys);
            if (is_array($this->paypal_keys) && isset($this->paypal_keys['client_id'], $this->paypal_keys['currency'])) {
                $this->dispatch('paypalKeysUpdated', [
                    'client_id' => Crypt::decryptString($this->paypal_keys['client_id']),
                    'currency' => $this->paypal_keys['currency'],
                    'amount' => $nextStep->amount
                ]);
            }

            // if (!empty($nextStep->file_type)) {
            $this->dispatch('setFileType', json_decode($nextStep->file_type, true) ?? ['']);
            // }

        } catch (\Throwable $e) {
            // \Log::error('Error in goToNext: ' . $e->getMessage(), [
            //     'line' => $e->getLine(),
            //     'file' => $e->getFile(),
            //     'trace' => $e->getTraceAsString()
            // ]);
            logger( [
                'Error in goToNext: ' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            // session()->flash('error', 'Something went wrong. Please try again.');
        }
    }

    public function goToPrevious($id, $action)
    {

        $step = $this->steps->findOrFail($id);

        if ($action) {
            $previous = $step->getPreviousStep($action);
        }


        $this->nextStep = $previous;
    }


    public function saveContact()
    {

        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }

        $step = $this->steps->findorFail($this->nextStep);

        $existingResponse = $step->responses()->where('user_token', $this->userToken)->first();

        if ($existingResponse) {
            $existingResponse->update([
                'name' => $this->name,
                'email' => $this->email,
                'phonenumber' => $this->phonenumber,
                'productname' => $this->productname,
                'consent' => $this->consent ?? false,
                'additionaltext' => $this->additionaltext,
            ]);
        } else {
            $step->responses()->create([
                'uuid' => Str::uuid(),
                'user_token' => $this->userToken,
                'name' => $this->name,
                'email' => $this->email,
                'phonenumber' => $this->phonenumber,
                'productname' => $this->productname,
                'consent' => $this->consent ?? false,
                'additionaltext' => $this->additionaltext,
            ]);
        }
    }


    // $filename = 'video_' . time() . '.webm';
    // $path = $this->videoResponse->storeAs('response-videos', $filename, 'public');


    public function saveText()
    {
        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }

        $step = $this->steps->findorFail($this->nextStep);

        $existingResponse = $step->responses()->where('user_token', $this->userToken)->first();

        if ($existingResponse) {
            $existingResponse->update([
                'text' => $this->textResponse,
            ]);
        } else {
            $step->responses()->create([
                'uuid' => Str::uuid(),
                'user_token' => $this->userToken,
                'text' => $this->textResponse,
            ]);
        }
    }


    public function saveVideo()
    {
        if ($this->preview) {
            return;
        }


        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }

        if (!$this->videoResponse) {
            return response()->json(['error' => 'No video file uploaded'], 400);
        }

        $cloudinary = new Cloudinary();
        $cloudinaryResponse = $cloudinary->uploadApi()->upload($this->videoResponse->getRealPath(), [
            'resource_type' => 'video',
            'folder' => 'videos',
        ]);
        $cloudinaryUrl = $cloudinaryResponse['secure_url'];

        $step = $this->steps->findorFail($this->nextStep);

        $existingResponse = $step->responses()->where('user_token', $this->userToken)->first();

        if ($existingResponse) {
            $existingResponse->update([
                'video' => $cloudinaryUrl,
            ]);
        } else {
            $step->responses()->create([
                'uuid' => Str::uuid(),
                'user_token' => $this->userToken,
                'video' => $cloudinaryUrl,
            ]);
        }
    }

    public function saveAudio()
    {
        if ($this->preview) {
            return;
        }

        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }

        if (!$this->audioResponse) {
            return response()->json(['error' => 'No audio file uploaded'], 400);
        }


        $cloudinary = new Cloudinary();


        $cloudinaryResponse = $cloudinary->uploadApi()->upload($this->audioResponse->getRealPath(), [
            'resource_type' => 'video',
            'folder' => 'audios',
        ]);
        $cloudinaryUrl = $cloudinaryResponse['secure_url'];

        $step = $this->steps->findorFail($this->nextStep);

        $existingResponse = $step->responses()->where('user_token', $this->userToken)->first();

        if ($existingResponse) {
            $existingResponse->update([
                'audio' => $cloudinaryUrl,
            ]);
        } else {
            $step->responses()->create([
                'uuid' => Str::uuid(),
                'user_token' => $this->userToken,
                'audio' => $cloudinaryUrl,
            ]);
        }
    }


    // Method to handle changes in the selected options (if necessary)
    public function saveSelectedOptions()
    {
        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }


        $step = $this->steps->findorFail($this->nextStep);

        $multi_choice_setting = json_decode($step->multi_choice_setting, true);

        // dd($multi_choice_setting);

        $skipDataStatus = false;

        foreach ($multi_choice_setting as $setting) {
            if ($setting['name'] === 'skip_data_collection') {
                $skipDataStatus = $setting['status'];
                break;
            }
        }

        if ($skipDataStatus) {
            return;
        }

        $existingResponse = $step->responses()->where('user_token', $this->userToken)->first();

        if ($existingResponse) {
            $existingResponse->update([
                'multi_option_response' => json_encode($this->selectedOptions),
            ]);
        } else {
            $step->responses()->create([
                'uuid' => Str::uuid(),
                'user_token' => $this->userToken,
                'multi_option_response' => json_encode($this->selectedOptions),
            ]);
        }
    }


    #[On('update-file')]
    public function update_file($url)
    {
        if ($this->preview) {
            return;
        }

        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }

        $step = $this->steps->findorFail($this->nextStep);

        $existingResponse = $step->responses()->where('user_token', $this->userToken)->first();

        if ($existingResponse) {
            $existingResponse->update([
                'file_upload' => $url,
            ]);
        } else {
            $step->responses()->create([
                'uuid' => Str::uuid(),
                'user_token' => $this->userToken,
                'file_upload' => $url,
            ]);
        }
    }

    public function saveNPSScore()
    {


        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }

        $step = $this->steps->findorFail($this->nextStep);

        $existingResponse = $step->responses()->where('user_token', $this->userToken)->first();

        if ($existingResponse) {
            $existingResponse->update([
                'nps_score' => $this->NPSScore,
            ]);
        } else {
            $step->responses()->create([
                'user_token' => $this->userToken,
                'nps_score' => $this->NPSScore,
            ]);
        }
    }



    public function render()
    {
        return view('livewire.show-campaign')->layout('layouts.custom');
    }
}
