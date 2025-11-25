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
     * Create a new Session instance configured with an OAuth token and API base URL.
     *
     * @param string|null $oauthToken OAuth2 token used to authenticate requests.
     * @param string $url Base API URL (defaults to production).
     * @param array $clientOptions Optional Guzzle client options to merge with defaults.
     *
     * @throws AuthTokenNotSuppliedException If no OAuth token is provided.
     */
    public function __construct(?string $oauthToken = null, string $url = 'https://www.freelancer.com', array $clientOptions = [])
    {
        if (!$oauthToken) {
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
     * Retrieve the internal Guzzle HTTP client used to perform API requests.
     *
     * @return Client The configured Guzzle HTTP client.
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * The base API URL used for requests.
     *
     * @return string The base API URL.
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