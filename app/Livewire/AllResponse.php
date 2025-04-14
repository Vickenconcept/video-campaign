<?php

namespace App\Livewire;

use Livewire\Component;

class AllResponse extends Component
{
    public $responses, $activeResponse, $responsesByToken, $activeIndex;

    // public function mount()
    // {

    //     $user = auth()->user(); // or inject $user as needed

    //     $this->responses = $user->folders()
    //         ->with([
    //             'campaigns.steps.responses'
    //         ])
    //         ->get()
    //         ->flatMap(function ($folder) {
    //             return $folder->campaigns->flatMap(function ($campaign) {
    //                 return $campaign->steps->flatMap(function ($step) {
    //                     return $step->responses;
    //                 });
    //             });
    //         })
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
    // }

    // public function mount()
    // {
    //     // Get the authenticated user
    //     $user = auth()->user();

    //     // Get all responses from the user's folders, campaigns, steps, and their associated responses
    //     $allResponses = $user->folders()
    //         ->with('campaigns.steps.responses') // eager load the relationships
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

    //     // Group responses by user_token
    //     $this->responses = $allResponses
    //         ->groupBy('user_token')
    //         ->map(function ($responsesGroup) {
    //             $merged = [];

    //             // Collect all unique keys (attributes) used in the responses
    //             $allKeys = collect($responsesGroup)->flatMap(fn($r) => array_keys($r->getAttributes()))->unique();

    //             // Iterate over each key and merge responses
    //             foreach ($allKeys as $key) {
    //                 $firstValue = null;

    //                 // Find the first non-empty value for this key
    //                 foreach ($responsesGroup as $response) {
    //                     $value = $response->$key ?? null;
    //                     if (!empty($value)) {
    //                         $firstValue = $value;
    //                         break; // stop after the first non-empty value
    //                     }
    //                 }

    //                 // Set the merged value (null if no value found)
    //                 $merged[$key] = $firstValue;
    //             }

    //             return (object) $merged; // Return the merged response as an object
    //         })
    //         ->values(); // Get the values of the grouped responses

    //     // Get the latest response based on the creation date
    //     $latest = $allResponses->sortByDesc('created_at')->first();

    //     // Set the active response to the latest one
    //     // $this->activeResponse = $latest ? (object) $latest->getAttributes() : null;
    // }



    public function mount()
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

        $this->responsesByToken = $allResponses->groupBy('user_token');

        $this->responses = $allResponses
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

        $latest = $allResponses->sortByDesc('created_at')->first();

        $this->activeResponse = $this->responses->firstWhere('user_token', $latest->user_token ?? null);
    }

    public function setResponse($user_token)
    {
        $this->activeResponse = $this->responses->firstWhere('user_token', $user_token);
        $this->activeIndex = '0';
    }
    public function showResponse($index)
    {
        $this->activeIndex = $index;
    }


    public function render()
    {
        return view('livewire.all-response')->layout('layouts.app');
    }
}
