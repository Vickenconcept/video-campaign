<?php

namespace App\Livewire;

use App\Models\Campaign;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\On;
use Cloudinary\Cloudinary;
use Illuminate\Support\Str;

class ShowCampaign extends Component
{
    use WithFileUploads;

    public $campaign, $steps;
    public $nextStep;
    public $preview;
    public $contactDetailShownStepId;
    public $userToken;


    public $videoResponse, $textResponse, $audioResponse;

    public function mount($uuid)
    {
        if (!session()->has('user_token')) {
            $userToken = Str::uuid()->toString();
            session(['user_token' => $userToken]);
        } else {
            $this->userToken = session('user_token');
        }
        $this->campaign = Campaign::where('uuid', $uuid)->firstOrFail();

        $this->steps = $this->campaign->steps;

        $this->preview = request()->has('preview');

        foreach ($this->steps as $step) {
            if ($step->contact_detail) {
                $this->contactDetailShownStepId = $step->id;
                break;
            }
        }

        $this->nextStep = $this->steps->min('position');
    }


    public function goToNext($id, $action)
    {

        if (trim($this->textResponse) !== '') {
            $this->saveText();
        } else {
            session()->flash('error', 'Text response cannot be empty.');
        }

        // =====================================
        // =====================================
        // =====================================

        $currentStep = $this->steps->findOrFail($id);

        $nextStepId = $currentStep->getNextStep($action);

        $nextStep = $this->steps->findOrFail($nextStepId);

        $previous = json_decode($nextStep->previous, true) ?? [];

        $previous = [$action => $id];

        $nextStep->update([
            'previous' => json_encode($previous),
        ]);

        $this->nextStep = $nextStepId;
    }

    public function goToPrevious($id, $action)
    {

        $step = $this->steps->findOrFail($id);

        if ($action) {
            $previous = $step->getPreviousStep($action);
        }


        $this->nextStep = $previous;
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
                'user_token' => $this->userToken,
                'text' => $this->textResponse,
            ]);
        }
    }


    public function saveVideo()
    {
        if (!$this->userToken) {
            return response()->json(['error' => 'User token not found'], 400);
        }

        if ($this->videoResponse) {
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
                    'user_token' => $this->userToken,
                    'video' => $cloudinaryUrl,
                ]);
            }
        } else {
            logger('No video uploaded');
        }
    }

    public function saveAudio()
    {

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
                'user_token' => $this->userToken,
                'audio' => $cloudinaryUrl,
            ]);
        }
    }


    public function render()
    {
        return view('livewire.show-campaign')->layout('layouts.guest');
    }
}
