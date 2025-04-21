<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\MailChimpService;
use App\Services\GetResponseService;
use App\Services\ConvertKitService;
use App\Models\EspConnection;
use App\Services\ActiveCampaignService;
use App\Services\HubSpotService;
use Illuminate\Support\Facades\Auth;

class EspConnector extends Component
{
    public $activeTab = 'mailchimp';
    public $mailchimpApiKey;
    public $mailchimpServerPrefix;
    public $getResponseApiKey;
    public $convertKitApiKey;
    public $activeCampaignApiKey;
    public $activeCampaignAccount;
    public $hubspotApiKey;

    public $targetEsp;
    public $targetList;
    public $email;
    public $emails;
    public $selectedEmails = [];

    public $mailchimpLists = [];
    public $getResponseLists = [];
    public $convertKitLists = [];
    public $activecampaignAuth = false;
    public $hubspotAuth = false;

    public $connectionStatus = [
        'mailchimp' => false,
        'getresponse' => false,
        'convertkit' => false,
        'activecampaign' => false,
        'hubspot' => false,
    ];

    protected $rules = [
        'mailchimpApiKey' => 'required_if:activeTab,mailchimp',
        'mailchimpServerPrefix' => 'required_if:activeTab,mailchimp',
        'getResponseApiKey' => 'required_if:activeTab,getresponse',
        'convertKitApiKey' => 'required_if:activeTab,convertkit',
        'activeCampaignApiKey' => 'required_if:activeTab,activecampaign',
        'activeCampaignAccount' => 'required_if:activeTab,activecampaign',
        'hubspotApiKey' => 'required_if:activeTab,hubspot',
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
            } elseif ($connection->service === 'activecampaign') {
                $this->activeCampaignApiKey = $connection->api_key;
                $this->activeCampaignAccount = $connection->account_name;
                $this->connectionStatus['activecampaign'] = true;
            } elseif ($connection->service === 'hubspot') {
                $this->hubspotApiKey = $connection->api_key;
                $this->connectionStatus['hubspot'] = true;
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




        if (!empty($this->connectionStatus['convertkit']) && !empty($this->convertKitApiKey)) {
            $convertKit = new ConvertKitService();
            $this->convertKitLists = $convertKit->getList($this->convertKitApiKey);
        }

        if (!empty($this->connectionStatus['mailchimp']) && !empty($this->mailchimpApiKey) && !empty($this->mailchimpServerPrefix)) {
            $mailChimpService = new MailChimpService();
            $lists = $mailChimpService->getAllLists($this->mailchimpApiKey, $this->mailchimpServerPrefix);
            $this->mailchimpLists = json_decode(json_encode($lists->lists), true);
        }

        if (!empty($this->connectionStatus['getresponse']) && !empty($this->getResponseApiKey)) {
            $getResponse = new GetResponseService();
            $this->getResponseLists = $getResponse->getAudience($this->getResponseApiKey);
        }

        // $convertKit = new ConvertKitService();
        // $this->convertKitLists = $convertKit->getList($this->convertKitApiKey);

        // $mailChimpService = new MailChimpService();
        // $lists = $mailChimpService->getAllLists($this->mailchimpApiKey, $this->mailchimpServerPrefix);
        // $this->mailchimpLists =  $lists = json_decode(json_encode($lists->lists), true);

        // $getResponse = new GetResponseService();
        // $this->getResponseLists = $getResponse->getAudience($this->getResponseApiKey);
    }

    public function connectMailchimp(MailChimpService $mailChimpService)
    {
        $this->validate([
            'mailchimpApiKey' => 'required',
            'mailchimpServerPrefix' => 'required',
        ]);

        try {
            $lists = $mailChimpService->getAllLists($this->mailchimpApiKey, $this->mailchimpServerPrefix);

            $lists = json_decode(json_encode($lists->lists), true);
            if (is_array($lists)) {
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

                $this->mailchimpLists = $lists;
                $this->connectionStatus['mailchimp'] = true;
                $this->dispatch('notify', status: 'success', msg: "Connected successfully");
            }
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
            $lists = $getResponse->getAudience($this->getResponseApiKey);
            if (is_array($lists)) {
                EspConnection::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'service' => 'getresponse'
                    ],
                    [
                        'api_key' => $this->getResponseApiKey,
                    ]
                );


                $this->getResponseLists = $lists;
                $this->connectionStatus['getresponse'] = true;
                $this->dispatch('notify', status: 'success', msg: "Connected successfully");
            }
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
            if (is_array($lists)) {
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
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Failed to connect: ' . $e->getMessage()]);
        }
    }

    // In your Livewire component
    public function connectActiveCampaign()
    {
        $this->validate([
            'activeCampaignApiKey' => 'required',
            'activeCampaignAccount' => 'required',
        ]);

        try {
            // Initialize and verify the connection
            $activeCampaign = new ActiveCampaignService(
                $this->activeCampaignApiKey,
                $this->activeCampaignAccount
            );

            if (!$activeCampaign->verifyConnection()) {
                throw new \Exception('Could not verify connection with provided credentials');
            }

            EspConnection::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'service' => 'activecampaign'
                ],
                [
                    'api_key' => $this->activeCampaignApiKey,
                    'account_name' => $this->activeCampaignAccount,
                ]
            );

            $this->activecampaignAuth = true;
            $this->connectionStatus['activecampaign'] = true;
            $this->dispatch('notify', status: 'success', msg: "Connected successfully");
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Failed to connect: ' . $e->getMessage()]);
        }
    }


    public function connectHubSpot()
    {
        $this->validate([
            'hubspotApiKey' => 'required',
        ]);

        try {
            $hubspot = new HubSpotService($this->hubspotApiKey);

            if (!$hubspot->verifyConnection()) {
                throw new \Exception('Could not verify connection with provided API key');
            }

            EspConnection::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'service' => 'hubspot'
                ],
                [
                    'api_key' => $this->hubspotApiKey,
                ]
            );

            $this->hubspotAuth = true;
            $this->connectionStatus['hubspot'] = true;
            $this->dispatch('notify', status: 'success', msg: "Connected successfully");
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Failed to connect HubSpot: ' . $e->getMessage()
            ]);
        }
    }


    public function migrateSubscriber()
    {

        $this->validate([
            'targetEsp' => 'required',
            'targetList' => $this->targetEsp === 'activecampaign' || $this->targetEsp === 'hubspot' ? 'sometimes' : 'required',
            'selectedEmails' => 'required|array|min:1',
        ], [
            'targetList.required' => 'Please select a list/tag for the target ESP',
            'selectedEmails.required' => 'Please select at least one email',
            'selectedEmails.min' => 'Please select at least one email',
        ]);


        try {
            $subscribers = $this->getSubscriberFromSource();

            $this->addSubscriberToTarget($subscribers);

            $successCount = count($subscribers['email']);

            // $this->dispatch('notify', status: 'success', msg: "Successfully migrated {$successCount} subscribers!");
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

        $successCount = count($subscriber['email']);


        // dd($this->targetEsp);
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
                $this->dispatch('notify', status: 'success', msg: "Successfully migrated {$successCount} subscribers!");
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
                $this->dispatch('notify', status: 'success', msg: "Successfully migrated {$successCount} subscribers!");
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
                $this->dispatch('notify', status: 'success', msg: "Successfully migrated {$successCount} subscribers!");
                break;

            case 'activecampaign':
                $activeCampaign = new ActiveCampaignService(
                    $this->activeCampaignApiKey,
                    $this->activeCampaignAccount
                );
                foreach ($subscriber['email'] as $email) {
                    try {
                        $res = $activeCampaign->createContact(
                            $email,
                            $subscriber['name'] ?? null,
                            null, // last name
                            null, // phone
                            [], // custom fields
                            $this->targetList // list ID
                        );
                    } catch (\Exception $e) {
                        logger()->error("ActiveCampaign contact creation failed for {$email}: " . $e->getMessage());
                        continue;
                    }
                }

                $this->dispatch('notify', status: 'success', msg: "Successfully migrated {$successCount} subscribers!");
                break;
            case 'hubspot':
                $connection = EspConnection::where('user_id', Auth::id())
                    ->where('service', 'hubspot')
                    ->first();

                if (!$connection) {
                    throw new \Exception('HubSpot not connected');
                }

                $hubspot = new HubSpotService($connection->api_key);

                foreach ($subscriber['email'] as $email) {
                    try {
                        // $res = $hubspot->deleteContact($email);
                        $res = $hubspot->createContact(
                            $email,
                            $subscriber['name'] ?? null
                        );
                    } catch (\Exception $e) {
                        logger()->error("HubSpot contact creation failed for {$email}: " . $e->getMessage());
                        continue;
                    }
                }
                if ($res) {
                    $this->dispatch('notify', status: 'success', msg: "Successfully migrated {$successCount} subscribers!");
                }
                break;
        }
    }

    public function render()
    {
        return view('livewire.esp-connector')->layout('layouts.app');
    }
}
