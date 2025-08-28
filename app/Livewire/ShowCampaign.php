<?php

namespace App\Livewire;

use App\Models\Campaign;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\On;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ShowCampaign extends Component
{
    use WithFileUploads;

    public $campaign, $steps, $lastStep;
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



    protected function hasSteps()
    {
        return $this->steps && $this->steps->count() > 0;
    }

    public function mount($uuid)
    {
        try {
            // Generate a unique session-based token for this user
            // Include IP and user agent for additional uniqueness
            $userFingerprint = md5(request()->ip() . request()->userAgent() . $uuid);
            $sessionKey = 'user_token_' . $uuid . '_' . $userFingerprint;
            $sessionTimestampKey = 'user_token_timestamp_' . $uuid . '_' . $userFingerprint;
            
            // Check if session exists and is not expired (24 hours)
            $sessionAge = session($sessionTimestampKey);
            $isExpired = $sessionAge && (time() - $sessionAge) > 86400; // 24 hours
            
            if (!session()->has($sessionKey) || $isExpired) {
                $newToken = Str::uuid()->toString();
                session([$sessionKey => $newToken]);
                session([$sessionTimestampKey => time()]);
            }
            
            $this->userToken = session($sessionKey);
            
            // Clean up old sessions for this campaign
            $this->cleanupOldSessions($uuid);

            $this->campaign = Campaign::where('uuid', $uuid)->with('steps')->firstOrFail();
            $this->selectedLang =  $this->campaign->language;

            // Ensure steps are loaded and handle empty case
            $this->steps = $this->campaign->steps()->orderBy('id')->get();

            // Check if steps exist
            if ($this->steps && $this->steps->count() > 0) {
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
        } catch (\Exception $e) {
            Log::error('Error in ShowCampaign mount method', [
                'uuid' => $uuid,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Set default values to prevent undefined variable errors
            $this->steps = collect();
            $this->campaign = null;
        }
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
        if (!$this->hasSteps()) {
            return;
        }

        try {

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
            logger([
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
        if (!$this->hasSteps()) {
            return;
        }

        $step = $this->steps->findOrFail($id);

        if ($action) {
            $previous = $step->getPreviousStep($action);
        }
        $this->dispatch('$refresh');


        $this->nextStep = $previous;
    }


    public function saveContact()
    {
        if (!$this->hasSteps()) {
            return;
        }

        if (!$this->validateUserToken($this->campaign->uuid)) {
            return response()->json(['error' => 'Invalid or expired user session'], 400);
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



    public function saveText()
    {
        if (!$this->hasSteps()) {
            return;
        }

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
        if (!$this->hasSteps()) {
            return;
        }

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
        if (!$this->hasSteps()) {
            return;
        }

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
        if (!$this->hasSteps()) {
            return;
        }

        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }

        $step = $this->steps->findorFail($this->nextStep);
        
        $multi_choice_setting = json_decode($step->multi_choice_setting, true);
        
        
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
        if (!$this->hasSteps()) {
            return;
        }

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
        if (!$this->hasSteps()) {
            return;
        }

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
                'uuid' => Str::uuid(),
                'user_token' => $this->userToken,
                'nps_score' => $this->NPSScore,
            ]);
        }
    }



    /**
     * Clean up old user sessions for this campaign
     */
    private function cleanupOldSessions($uuid)
    {
        $sessionKeys = array_keys(session()->all());
        $campaignSessionKeys = array_filter($sessionKeys, function($key) use ($uuid) {
            return strpos($key, 'user_token_' . $uuid) === 0;
        });
        
        // Keep only the current session, remove others
        foreach ($campaignSessionKeys as $key) {
            if ($key !== 'user_token_' . $uuid . '_' . md5(request()->ip() . request()->userAgent() . $uuid)) {
                session()->forget($key);
            }
        }
    }
    
    /**
     * Validate user token and ensure it belongs to current session
     */
    private function validateUserToken($uuid)
    {
        if (!$this->userToken) {
            return false;
        }
        
        $userFingerprint = md5(request()->ip() . request()->userAgent() . $uuid);
        $sessionKey = 'user_token_' . $uuid . '_' . $userFingerprint;
        
        return session($sessionKey) === $this->userToken;
    }

    public function render()
    {
        return view('livewire.show-campaign')->layout('layouts.custom');
    }
}
