<?php

namespace FreelancerSdk;

use FreelancerSdk\Exceptions\AuthTokenNotSuppliedException;
use GuzzleHttp\Client;

/**
 * This class manages an HTTP session to the freelancer.com API.
 */
class Session
{
    private Client $client;

    private string $url;

    private string $oauthToken;

    /**
     * Create a new Session instance.
     *
     * @param string|null $oauthToken    OAuth2 token for authentication
     * @param string      $url           Base URL for the API (defaults to production)
     * @param array       $clientOptions Optional Guzzle client options (useful for testing: pass a handler)
     *
     * @throws AuthTokenNotSuppliedException
     */
    public function __construct(?string $oauthToken = null, string $url = 'https://www.freelancer.com', array $clientOptions = [])
    {
        if (! $oauthToken) {
            throw new AuthTokenNotSuppliedException('OAuth token not supplied');
        }

        $this->oauthToken = $oauthToken;
        $this->url        = $url;

        // Set default headers
        $defaults = [
            'base_uri' => $this->url,
            'headers'  => [
                'Freelancer-OAuth-V1' => $oauthToken,
                'User-Agent'          => 'Freelancer.com PHP SDK',
                'Accept'              => 'application/json',
                'Content-Type'        => 'application/json',
            ],
        ];
        $options      = array_replace_recursive($defaults, $clientOptions);
        $this->client = new Client($options);
    }

    /**
     * Get the HTTP client.
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Get the base URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the OAuth token.
     *
     * @return string
     */
    public function getOAuthToken(): string
    {
        return $this->oauthToken;
    }
}
