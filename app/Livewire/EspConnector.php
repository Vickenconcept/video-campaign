<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\MailChimpService;
use App\Services\GetResponseService;
use App\Services\ConvertKitService;
use App\Models\EspConnection;
use Illuminate\Support\Facades\Auth;

class EspConnector extends Component
{
    public $activeTab = 'mailchimp';
    public $mailchimpApiKey;
    public $mailchimpServerPrefix;
    public $getResponseApiKey;
    public $convertKitApiKey;

    public $targetEsp;
    public $targetList;
    public $email;
    public $emails;
    public $selectedEmails = [];

    public $mailchimpLists = [];
    public $getResponseLists = [];
    public $convertKitLists = [];

    public $connectionStatus = [
        'mailchimp' => false,
        'getresponse' => false,
        'convertkit' => false
    ];

    protected $rules = [
        'mailchimpApiKey' => 'required_if:activeTab,mailchimp',
        'mailchimpServerPrefix' => 'required_if:activeTab,mailchimp',
        'getResponseApiKey' => 'required_if:activeTab,getresponse',
        'convertKitApiKey' => 'required_if:activeTab,convertkit',
    ];

    public function mount()
    {


        // Load existing connections if any
        $connections = EspConnection::where('user_id', Auth::id())->get();

        foreach ($connections as $connection) {
            if ($connection->service === 'mailchimp') {
                $this->mailchimpApiKey = $connection->api_key;
                $this->mailchimpServerPrefix = $connection->server_prefix;
                $this->connectionStatus['mailchimp'] = true;
            } elseif ($connection->service === 'getresponse') {
                $this->getResponseApiKey = $connection->api_key;
                $this->connectionStatus['getresponse'] = true;
            } elseif ($connection->service === 'convertkit') {
                $this->convertKitApiKey = $connection->api_key;
                $this->connectionStatus['convertkit'] = true;
            }
        }

        $user = auth()->user();

        // Eager load nested relationships and retrieve all responses
        $responses = $user->folders()
            ->with('campaigns.steps.responses')
            ->get()
            ->flatMap(function ($folder) {
                return $folder->campaigns->flatMap(function ($campaign) {
                    return $campaign->steps->flatMap(function ($step) {
                        return $step->responses;
                    });
                });
            });

        // Extract email addresses, filter out nulls, ensure uniqueness, and convert to array
        $emails = $responses->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Store the emails array in a public property for use in your component
        $this->emails = $emails;
    }

    public function connectMailchimp(MailChimpService $mailChimpService)
    {
        $this->validate([
            'mailchimpApiKey' => 'required',
            'mailchimpServerPrefix' => 'required',
        ]);

        try {
            $lists = $mailChimpService->getAllLists($this->mailchimpApiKey, $this->mailchimpServerPrefix);

            // Save connection
            EspConnection::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'service' => 'mailchimp'
                ],
                [
                    'api_key' => $this->mailchimpApiKey,
                    'server_prefix' => $this->mailchimpServerPrefix,
                ]
            );

            $this->mailchimpLists = json_decode(json_encode($lists->lists), true);
            $this->connectionStatus['mailchimp'] = true;
            $this->dispatch('notify', status: 'success', msg: "Connected successfully");
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Failed to connect: ' . $e->getMessage()]);
        }
    }

    public function connectGetResponse(GetResponseService $getResponse)
    {
        $this->validate([
            'getResponseApiKey' => 'required',
        ]);

        try {
            // $getResponse = new GetResponseService();
            $lists = $getResponse->getAudience($this->getResponseApiKey);

            EspConnection::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'service' => 'getresponse'
                ],
                [
                    'api_key' => $this->getResponseApiKey,
                ]
            );

            // dd($lists);
            $this->getResponseLists = $lists;
            $this->connectionStatus['getresponse'] = true;
            $this->dispatch('notify', status: 'success', msg: "Connected successfully");
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Failed to connect: ' . $e->getMessage()]);
        }
    }

    public function connectConvertKit()
    {
        $this->validate([
            'convertKitApiKey' => 'required',
        ]);

        try {
            $convertKit = new ConvertKitService();
            $lists = $convertKit->getList($this->convertKitApiKey);

            EspConnection::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'service' => 'convertkit'
                ],
                [
                    'api_key' => $this->convertKitApiKey,
                ]
            );

            $this->convertKitLists = $lists;
            $this->connectionStatus['convertkit'] = true;
            $this->dispatch('notify', status: 'success', msg: "Connected successfully");
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Failed to connect: ' . $e->getMessage()]);
        }
    }


    public function migrateSubscriber()
    {
        $this->validate([
            'targetEsp' => 'required',
            'targetList' => 'required',
            'selectedEmails' => 'required', // Can be string or array
        ]);

        try {
            // Get subscribers from source ESP (now returns array)
            $subscribers = $this->getSubscriberFromSource();

            // Add to target ESP (handles array)
            $this->addSubscriberToTarget($subscribers);

            $successCount = count($subscribers);

            $this->dispatch('notify', status: 'success', msg: "Successfully migrated {$successCount} subscribers!");
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Migration failed: ' . $e->getMessage()
            ]);
        }
    }

    protected function getSubscriberFromSource()
    {
        // $emails = is_array($this->email) ? $this->email : [$this->email];
        $emails = $this->selectedEmails;

        return [
            'email' => $emails,
            'name' => 'Subscriber Name' // You would get this from the source ESP
        ];
    }

    protected function addSubscriberToTarget($subscriber)
    {
        $connection = EspConnection::where('user_id', Auth::id())
            ->where('service', $this->targetEsp)
            ->first();

        if (!$connection) {
            throw new \Exception('Target ESP not connected');
        }

        switch ($this->targetEsp) {
            case 'mailchimp':
                $mailchimp = new MailChimpService();
                foreach ($subscriber['email'] as $email) {
                    try {
                        $mailchimp->subscribe(
                            $email,
                            $connection->api_key,
                            $connection->server_prefix,
                            $this->targetList
                        );
                    } catch (\Exception $e) {
                        // Log failed attempts but continue with others
                        logger()->error("Failed to subscribe {$email}: " . $e->getMessage());
                        continue;
                    }
                }
                break;

         
            case 'getresponse':
                $getResponse = new GetResponseService();
                foreach ($subscriber['email'] as $email) {
                    try {
                        $getResponse->createContact(
                            $connection->api_key,
                            $this->targetList,
                            $subscriber['name'] ?? 'Subscriber', // Fallback name
                            $email
                        );
                    } catch (\Exception $e) {
                        logger()->error("Failed to create GetResponse contact {$email}: " . $e->getMessage());
                        continue;
                    }
                }
                break;

            case 'convertkit':
                $convertKit = new ConvertKitService();
                foreach ($subscriber['email'] as $email) {
                    try {
                        $convertKit->addEmail(
                            $connection->api_key,
                            $this->targetList,
                            $email
                        );
                    } catch (\Exception $e) {
                        logger()->error("Failed to add ConvertKit subscriber {$email}: " . $e->getMessage());
                        continue;
                    }
                }
                break;
        }
    }

    public function render()
    {
        return view('livewire.esp-connector')->layout('layouts.app');
    }
}
