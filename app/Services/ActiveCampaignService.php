<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ActiveCampaignService
{
    private $client;
    private $baseUrl;
    private $apiToken;
    private $accountName;

    // public function __construct(?string $apiToken = null, ?string $accountName = null)
    // {
    //     if ($apiToken && $accountName) {
    //         $this->initialize($apiToken, $accountName);
    //     }
    // }

    public function __construct(string $apiToken, string $accountName)
    {
        $this->apiToken = $apiToken;
        $this->accountName = $accountName;

        $this->client = new Client([
            'base_uri' => "https://{$this->accountName}.api-us1.com/",
            'headers' => [
                'Api-Token' => $this->apiToken, // your full API token
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'timeout' => 10
        ]);
    }


    


    // public function verifyConnection()
    // {
    //     try {
    //         $response = $this->client->get('/accounts');
    //         dd($response);
    //         return $response->getStatusCode() === 200;
    //     } catch (\Exception $e) {
    //         return false;
    //     }
    // }

    public function verifyConnection(): bool
    {
        try {

            // Then try a more substantial endpoint
            $accountsResponse = $this->client->get('api/3/accounts', [
                'query' => ['limit' => 1] // Get minimal data
            ]);

            $data = json_decode($accountsResponse->getBody(), true);

            return isset($data['accounts']);
        } catch (\Exception $e) {
            logger()->error('ActiveCampaign connection verification failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }


    public function createContact(
        string $email,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phone = null,
        array $customFields = [],
        ?int $listId = null
    ): array {
        if (!$this->client) {
            throw new \RuntimeException('ActiveCampaign service not initialized with API credentials');
        }

        $contactData = [
            'email' => $email,
        ];

        if ($firstName) {
            $contactData['firstName'] = $firstName;
        }

        if ($lastName) {
            $contactData['lastName'] = $lastName;
        }

        if ($phone) {
            $contactData['phone'] = $phone;
        }

        
        $fieldValues = [];
        foreach ($customFields as $fieldId => $value) {
            $fieldValues[] = [
                'field' => $fieldId,
                'value' => $value,
            ];
        }

        if (!empty($fieldValues)) {
            $contactData['fieldValues'] = $fieldValues;
        }

        
        try {
            $response = $this->client->post('api/3/contacts', [
                'json' => ['contact' => $contactData]
            ]);

            $contact = json_decode($response->getBody(), true);

            // Add to list if specified
            if ($listId) {
                $this->addContactToList($contact['contact']['id'], $listId);
            }

            
            return $contact;
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse();
            $errorDetails = json_decode($errorResponse->getBody()->getContents(), true);

            Log::error('ActiveCampaign API Error', [
                'status' => $errorResponse->getStatusCode(),
                'errors' => $errorDetails['errors'] ?? [],
                'message' => $errorDetails['message'] ?? 'Unknown error',
            ]);

            throw new \Exception('Failed to create ActiveCampaign contact: ' . ($errorDetails['message'] ?? $e->getMessage()));
        }
    }

    public function addContactToList(int $contactId, int $listId): array
    {
        try {
            $response = $this->client->post('/contactLists', [
                'json' => [
                    'contactList' => [
                        'list' => $listId,
                        'contact' => $contactId,
                        'status' => 1, // 1 = active, 2 = unsubscribed
                    ]
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse();
            $errorDetails = json_decode($errorResponse->getBody()->getContents(), true);

            throw new \Exception('Failed to add contact to list: ' .
                ($errorDetails['message'] ?? $e->getMessage()));
        }
    }

    // ... (keep all other methods from previous implementation)
}
