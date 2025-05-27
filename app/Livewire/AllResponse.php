<?php

namespace App\Livewire;

use App\Jobs\SendRawMailJob;
use App\Models\Response;
use Livewire\Component;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;

class AllResponse extends Component
{
    use WithFileUploads;

    public $responses, $activeResponse, $responsesByToken, $activeIndex;
    public $audioResponse, $videoResponse, $textResponse, $active_response_token;

    public $url, $email, $name, $phonenumber, $message, $message_2;

    public $filterEmail = false;
    public $filterVideo = false;
    public $filterText = false;
    public $filterAudio = false;
    public $filterNps = false;


    public ?string $user_token = null;
    public ?string $dateFilter = null; // 'day', 'week', 'month', 'year'
    public ?string $customDate = null;




    public function mount($user_token = null)
    {
        $this->user_token = $user_token;
        $this->message_2 = " Copy and paste response link\n ";
        $this->loadResponses();
    }




    public function loadResponses()
    {
        $user = auth()->user();

        $userId = $user->id;
        $cacheKey = 'responses_data_user_' . $userId;

        $folders = Cache::remember($cacheKey, 60, function () use ($user) {
            return $user->folders()
                ->with('campaigns.steps.responses')
                ->get();
        });

        $allResponses = $folders->flatMap(
            fn($folder) =>
            $folder->campaigns->flatMap(
                fn($campaign) =>
                $campaign->steps->flatMap(
                    fn($step) =>
                    $step->responses
                )
            )
        );

        // Filter by user_token if available
        if ($this->user_token) {
            $allResponses = $allResponses->where('user_token', $this->user_token);
        }


        if ($this->customDate) {
            $allResponses = $allResponses->filter(function ($response) {
                $created = \Carbon\Carbon::parse($response->created_at);
                return $created->isSameDay(\Carbon\Carbon::parse($this->customDate));
            });
        } elseif ($this->dateFilter) {
            $allResponses = $allResponses->filter(function ($response) {
                $created = \Carbon\Carbon::parse($response->created_at);
                $now = now();
                return match ($this->dateFilter) {
                    'day' => $created->isToday(),
                    'week' => $created->isSameWeek($now),
                    'month' => $created->isSameMonth($now),
                    'last_month' => $created->isSameMonth($now->copy()->subMonth()),
                    'last_2_months' => $created->between($now->copy()->subMonths(2)->startOfMonth(), $now->copy()->subMonth()->endOfMonth()),
                    'year' => $created->isSameYear($now),
                    default => true,
                };
            });
        }

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

        Cache::forget('responses_data_user_' . auth()->id());
    }



    public function applyFilters($responses)
    {
        $filters = [
            'filterEmail' => $this->filterEmail,
            'filterVideo' => $this->filterVideo,
            'filterText' => $this->filterText,
            'filterAudio' => $this->filterAudio,
            'filterNps' => $this->filterNps,
            'dateFilter' => $this->dateFilter,
            'customDate' => $this->customDate,
        ];

        if (!array_filter($filters)) {
            return $responses;
        }

        return $responses->filter(function ($response) use ($filters) {
            return ($filters['filterEmail'] && !empty($response->email)) ||
                ($filters['filterVideo'] && !empty($response->video)) ||
                ($filters['filterText'] && !empty($response->text)) ||
                ($filters['filterAudio'] && !empty($response->audio)) ||
                ($filters['dateFilter'] && !empty($response->created_at)) ||
                ($filters['customDate'] && !empty($response->created_at)) ||
                ($filters['filterNps'] && !empty($response->nps_score));
        });
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterEmail', 'filterVideo', 'filterText', 'filterAudio', 'filterNps', 'dateFilter', 'customDate'])) {
            $this->loadResponses();
        }
    }



    public function setResponse($user_token)
    {
        $this->activeResponse = $this->responses->firstWhere('user_token', $user_token);
        $this->email = optional($this->activeResponse)->email;
        $this->name = optional($this->activeResponse)->name;
        $this->phonenumber = optional($this->activeResponse)->phonenumber;
    }


    public function showResponse($index)
    {
        $this->activeIndex = $index;
    }

    public function setActiveResponse($user_token)
    {
        $this->active_response_token = $user_token;
    }

    public function selectResponseById($id)
    {
        if ($id) {

            $activeResponse = Response::firstWhere('id', $id);
            $this->url =  route('response.single', ['uuid' => $activeResponse->uuid]);
            $this->name =  $activeResponse->name;
            $this->email =  $activeResponse->email;

            return $this->skipRender();
        }
    }


    public function sendResponse()
    {
        $this->validate([
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
        ]);

        $name = $this->name;
        $email = $this->email;
        $message = $this->message;

        $link = $this->url;


        $mailBody = "
            Name: {$name}\n
            Email: {$email}\n
            Message: {$message}\n\n
            View the full response here: {$link}
        ";


        Mail::raw($mailBody, function ($msg) use ($email) {
            $msg->to($email)
                ->subject('Action Required');
        });

        $this->dispatch('notify', status: 'success', msg: 'Response sent successfully!');
    }



    public function respondAll()
    {
        $responses = Response::all();

        $message = $this->message_2;
        // $link = $this->url;


        $sentEmails = [];

        foreach ($responses as $response) {
            $email = $response->email;

            if (in_array($email, $sentEmails)) {
                continue;
            }

            $sentEmails[] = $email;

            $name = $response->name;

            $mailBody = "
                Name: {$name}\n
                Email: {$email}\n
                Message: {$message}\n\n
                ";

            SendRawMailJob::dispatch($email, $mailBody);
        }

        $this->dispatch('notify', status: 'success', msg: 'Responses sent successfully!');
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
            'step_id' => optional($this->activeResponse)->step_id,
            'uuid' => Str::uuid(),
            'user_token' => optional($this->activeResponse)->user_token,
            'email' => optional($this->activeResponse)->email ?? null,
            'name' => optional($this->activeResponse)->name ?? null,
            'audio' => $cloudinaryUrl,
            'type' => 'creator'
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Replyed successfully!');
        $this->dispatch('refreshPage');

        Cache::forget('responses_data_user_' . auth()->id());
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
            'step_id' => optional($this->activeResponse)->step_id,
            'uuid' => Str::uuid(),
            'user_token' => optional($this->activeResponse)->user_token,
            'email' => optional($this->activeResponse)->email ?? null,
            'name' => optional($this->activeResponse)->name ?? null,
            'video' => $cloudinaryUrl,
            'type' => 'creator'
        ]);
        $this->dispatch('notify', status: 'success', msg: 'Replyed successfully!');
        $this->dispatch('refreshPage');

        Cache::forget('responses_data_user_' . auth()->id());
    }

    public function saveText()
    {
        Response::create([
            'step_id' => optional($this->activeResponse)->step_id,
            'uuid' => Str::uuid(),
            'user_token' => optional($this->activeResponse)->user_token,
            'email' => optional($this->activeResponse)->email ?? null,
            'name' => optional($this->activeResponse)->name ?? null,
            'text' => $this->textResponse,
            'type' => 'creator'
        ]);


        $this->dispatch('notify', status: 'success', msg: 'Replyed successfully!');
        $this->dispatch('refreshPage');

        Cache::forget('responses_data_user_' . auth()->id());
    }

    public function deleteResponsesByToken()
    {
        Response::where('user_token', $this->active_response_token)->delete();

        $this->loadResponses();

        if ($this->activeResponse && optional($this->activeResponse)->user_token === $this->active_response_token) {
            $this->activeResponse = null;
        }
        $this->dispatch('notify', status: 'success', msg: 'Deleted successfully!');

        Cache::forget('responses_data_user_' . auth()->id());
    }


    public function editContact()
    {

        $activeResponse = Response::firstWhere('id', optional($this->activeResponse)->id);

        $activeResponse->update([
            'email' =>  $this->email,
            'name' =>  $this->name,
            'phonenumber' =>  $this->phonenumber,
        ]);

        $this->loadResponses();

        $this->dispatch('notify', status: 'success', msg: 'Updated successfully!');

        Cache::forget('responses_data_user_' . auth()->id());
    }

    public function clearFilters()
    {
        $this->dateFilter = null;
        $this->customDate = null;
        $this->filterEmail = false;
        $this->filterVideo = false;
        $this->filterText = false;
        $this->filterAudio = false;
        $this->filterNps = false;
        $this->loadResponses();
    }

    public function render()
    {
        return view('livewire.all-response')->layout('layouts.app');
    }
}
