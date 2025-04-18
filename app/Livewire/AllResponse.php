<?php

namespace App\Livewire;

use App\Models\Response;
use Livewire\Component;
use Cloudinary\Cloudinary;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AllResponse extends Component
{
    use WithFileUploads;

    public $responses, $activeResponse, $responsesByToken, $activeIndex;
    public $audioResponse, $videoResponse, $textResponse, $active_response_token;


    public $filterEmail = false;
    public $filterVideo = false;
    public $filterText = false;
    public $filterAudio = false;
    public $filterNps = false;



    // public function mount()
    // {
    //     $user = auth()->user();

    //     $allResponses = $user->folders()
    //         ->with('campaigns.steps.responses')
    //         ->get()
    //         ->flatMap(
    //             fn($folder) =>
    //             $folder->campaigns->flatMap(
    //                 fn($campaign) =>
    //                 $campaign->steps->flatMap(
    //                     fn($step) =>
    //                     $step->responses
    //                 )
    //             )
    //         );

    //     $this->responsesByToken = $allResponses->groupBy('user_token');


    //     $this->responses = $allResponses
    //         ->sortByDesc('created_at') // or use 'id' if you prefer
    //         ->groupBy('user_token')
    //         ->map(function ($responsesGroup) {
    //             $merged = [];

    //             foreach ($responsesGroup as $response) {
    //                 foreach ($response->getAttributes() as $key => $value) {
    //                     if (!empty($value) && empty($merged[$key])) {
    //                         $merged[$key] = $value;
    //                     }
    //                 }
    //             }

    //             return (object) $merged;
    //         })
    //         ->values();


    //     $latest = $allResponses->sortByDesc('created_at')->first();

    //     $this->activeResponse = $this->responses->firstWhere('user_token', $latest->user_token ?? null);
    // }

    public function mount()
    {
        $this->loadResponses();
    }
    public function loadResponses()
    {
        $user = auth()->user();

        $allResponses = $user->folders()
            ->with('campaigns.steps.responses')
            ->get()
            ->flatMap(
                fn($folder) =>
                $folder->campaigns->flatMap(
                    fn($campaign) =>
                    $campaign->steps->flatMap(
                        fn($step) =>
                        $step->responses
                    )
                )
            );

        $filteredResponses = $this->applyFilters($allResponses);

        $this->responsesByToken = $filteredResponses->groupBy('user_token');

        $this->responses = $filteredResponses
            ->sortByDesc('created_at')
            ->groupBy('user_token')
            ->map(function ($responsesGroup) {
                $merged = [];

                foreach ($responsesGroup as $response) {
                    foreach ($response->getAttributes() as $key => $value) {
                        if (!empty($value) && empty($merged[$key])) {
                            $merged[$key] = $value;
                        }
                    }
                }

                return (object) $merged;
            })
            ->values();

        $latest = $filteredResponses->sortByDesc('created_at')->first();

        $this->activeResponse = $this->responses->firstWhere('user_token', $latest->user_token ?? null);
    }


    public function applyFilters($responses)
    {
        $filters = [
            'filterEmail' => $this->filterEmail,
            'filterVideo' => $this->filterVideo,
            'filterText' => $this->filterText,
            'filterAudio' => $this->filterAudio,
            'filterNps' => $this->filterNps,
        ];

        if (!array_filter($filters)) {
            return $responses;
        }

        return $responses->filter(function ($response) use ($filters) {
            return ($filters['filterEmail'] && !empty($response->email)) ||
                ($filters['filterVideo'] && !empty($response->video)) ||
                ($filters['filterText'] && !empty($response->text)) ||
                ($filters['filterAudio'] && !empty($response->audio)) ||
                ($filters['filterNps'] && !empty($response->nps_score));
        });
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterEmail', 'filterVideo', 'filterText', 'filterAudio', 'filterNps'])) {
            $this->loadResponses();
        }
    }



    public function setResponse($user_token)
    {
        $this->activeResponse = $this->responses->firstWhere('user_token', $user_token);
    }

    public function showResponse($index)
    {
        $this->activeIndex = $index;
    }

    public function setActiveResponse($user_token)
    {
        $this->active_response_token = $user_token;
    }


    public function saveAudio()
    {

        $cloudinary = new Cloudinary();


        $cloudinaryResponse = $cloudinary->uploadApi()->upload($this->audioResponse->getRealPath(), [
            'resource_type' => 'video',
            'folder' => 'audios',
        ]);
        $cloudinaryUrl = $cloudinaryResponse['secure_url'];


        Response::create([
            'step_id' => $this->activeResponse->step_id + 1,
            'uuid' => Str::uuid(),
            'user_token' => $this->activeResponse->user_token,
            'email' => $this->activeResponse->email ?? null,
            'name' => $this->activeResponse->name ?? null,
            'audio' => $cloudinaryUrl,
            'type' => 'creator'
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Replyed successfully!');
        $this->dispatch('refreshPage');
    }

    public function saveVideo()
    {

        $cloudinary = new Cloudinary();


        $cloudinaryResponse = $cloudinary->uploadApi()->upload($this->videoResponse->getRealPath(), [
            'resource_type' => 'video',
            'folder' => 'videos',
        ]);
        $cloudinaryUrl = $cloudinaryResponse['secure_url'];


        Response::create([
            'step_id' => $this->activeResponse->step_id + 1,
            'uuid' => Str::uuid(),
            'user_token' => $this->activeResponse->user_token,
            'email' => $this->activeResponse->email ?? null,
            'name' => $this->activeResponse->name ?? null,
            'video' => $cloudinaryUrl,
            'type' => 'creator'
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Replyed successfully!');
        $this->dispatch('refreshPage');
    }

    public function saveText()
    {
        Response::create([
            'step_id' => $this->activeResponse->step_id,
            'uuid' => Str::uuid(),
            'user_token' => $this->activeResponse->user_token,
            'email' => $this->activeResponse->email ?? null,
            'name' => $this->activeResponse->name ?? null,
            'text' => $this->textResponse,
            'type' => 'creator'
        ]);


        $this->dispatch('notify', status: 'success', msg: 'Replyed successfully!');
        $this->dispatch('refreshPage');
    }

    public function deleteResponsesByToken()
    {
        Response::where('user_token', $this->active_response_token)->delete();

        $this->loadResponses();

        if ($this->activeResponse && $this->activeResponse->user_token === $this->active_response_token) {
            $this->activeResponse = null;
        }
        $this->dispatch('notify', status: 'success', msg: 'Deleted successfully!');

    }



    public function render()
    {
        return view('livewire.all-response')->layout('layouts.app');
    }
}
