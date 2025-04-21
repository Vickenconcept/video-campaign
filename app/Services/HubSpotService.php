<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class HubSpotService
{
    private $client;
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => 'https://api.hubapi.com/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'timeout' => 15,
        ]);
    }

    /**
     * Create a new contact in HubSpot
     *
     * @param string $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $phone
     * @param array $additionalProperties
     * @return array
     * @throws \Exception
     */
    public function createContact(
        string $email,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phone = null,
        array $additionalProperties = []
    ) {
        $properties = array_merge([
            'email' => $email,
            'firstname' => $firstName ?? 'subscribers',
            'lastname' => $lastName ?? 'last name',
            'phone' => $phone,
        ], $additionalProperties);

        // Remove null values
        $properties = array_filter($properties, function ($value) {
            return $value !== null;
        });

        try {
            $response = $this->client->post('crm/v3/objects/contacts', [
                'json' => [
                    'properties' => $properties
                ]
            ]);

            return $response->getStatusCode() === 201;
            // $contact = json_decode($response->getBody(), true);
            // dd($response->getStatusCode(), $response);
            // return $contact;
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse();
            $errorDetails = json_decode($errorResponse->getBody()->getContents(), true);

            Log::error('HubSpot API Error', [
                'status' => $errorResponse->getStatusCode(),
                'errors' => $errorDetails['errors'] ?? [],
                'message' => $errorDetails['message'] ?? $e->getMessage(),
            ]);

            throw new \Exception('Failed to create HubSpot contact: ' . ($errorDetails['message'] ?? $e->getMessage()));
        }
    }
    public function deleteContact($email)
    {
        try {
            $response = $this->client->get("crm/v3/objects/contacts/{$email}?idProperty=email");

            $response = json_decode($response->getBody(), true);
            $deleteData = $this->client->delete("crm/v3/objects/contacts/{$response['id']}");
            // dd($response['id'], $deleteData);
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse();
            $errorDetails = json_decode($errorResponse->getBody()->getContents(), true);

            Log::error('HubSpot API Error', [
                'status' => $errorResponse->getStatusCode(),
                'errors' => $errorDetails['errors'] ?? [],
                'message' => $errorDetails['message'] ?? $e->getMessage(),
            ]);

            throw new \Exception('Failed to create HubSpot contact: ' . ($errorDetails['message'] ?? $e->getMessage()));
        }
    }

    /**
     * Verify API connection
     * @return bool
     */
    public function verifyConnection()
    {
        try {

            $response = $this->client->get('/integrations/v1/me');

            return $response->getStatusCode() === 200;

            // Check if we got a valid response
        } catch (\Exception $e) {
            logger()->error('HubSpot connection verification failed', [
                'error' => $e->getMessage(),
                'response' => method_exists($e, 'getResponse') ? $e->getResponse()->getBody()->getContents() : null
            ]);
            return false;
        }
    }
}
