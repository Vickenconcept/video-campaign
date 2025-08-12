<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class AyrshareService
{
    protected $client;
    protected $apiKey;
    protected $privateKey;
    protected $domain;
    protected $baseUrl = 'https://api.ayrshare.com/api';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.ayrshare.api_key');
        $this->privateKey = config('services.ayrshare.private_key');
        $this->domain = config('services.ayrshare.domain');
    }

    protected function headers($profileKey = null)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];
        if ($profileKey) {
            $headers['Profile-Key'] = $profileKey;
        }
        return $headers;
    }

    /**
     * Create a new user profile and return the profile key
     */
    public function createProfile($title, $options = [])
    {
        $body = array_merge(['title' => $title], $options);
        try {
            $response = $this->client->post("{$this->baseUrl}/profiles", [
                'headers' => $this->headers(),
                'json' => $body,
            ]);
            dd($response);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare createProfile error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate a JWT linking URL for connecting social accounts
     */
    public function generateJwtUrl($profileKey, $options = [])
    {
        $body = array_merge([
            'domain' => $this->domain,
            'privateKey' => $this->privateKey,
            'profileKey' => $profileKey,
        ], $options);
        try {
            $response = $this->client->post("{$this->baseUrl}/profiles/generateJWT", [
                'headers' => $this->headers(),
                'json' => $body,
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare generateJwtUrl error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * List all user profiles
     */
    public function listProfiles($query = [])
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/profiles", [
                'headers' => $this->headers(),
                'query' => $query,
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare listProfiles error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * List connected social accounts for a profile (via /user endpoint)
     */
    public function getProfileSocialAccounts($profileKey)
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/user", [
                'headers' => $this->headers($profileKey),
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare getProfileSocialAccounts error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Post (immediate or scheduled) to connected accounts
     * $body should include: post, platforms, mediaUrls, scheduleDate, etc.
     */
    public function postToSocial($profileKey, $body)
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/post", [
                'headers' => $this->headers($profileKey),
                'json' => $body,
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare postToSocial error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete a post by Ayrshare Post ID
     */
    public function deletePost($profileKey, $postId)
    {
        try {
            $response = $this->client->delete("{$this->baseUrl}/post", [
                'headers' => $this->headers($profileKey),
                'json' => ['id' => $postId],
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare deletePost error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get post status/history by Ayrshare Post ID
     */
    public function getPostStatus($profileKey, $postId)
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/post/{$postId}", [
                'headers' => $this->headers($profileKey),
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare getPostStatus error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Unlink a social account from a profile
     */
    public function unlinkSocialAccount($profileKey, $platform)
    {
        try {
            $response = $this->client->delete("{$this->baseUrl}/profiles/social", [
                'headers' => $this->headers($profileKey),
                'json' => ['platform' => $platform],
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare unlinkSocialAccount error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete a user profile
     */
    public function deleteProfile($profileKey, $title)
    {
        try {
            $response = $this->client->delete("{$this->baseUrl}/profiles", [
                'headers' => $this->headers($profileKey),
                'json' => ['title' => $title],
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (RequestException $e) {
            Log::error('Ayrshare deleteProfile error: ' . $e->getMessage());
            return null;
        }
    }
} 