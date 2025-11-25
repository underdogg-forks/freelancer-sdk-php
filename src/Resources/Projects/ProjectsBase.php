<?php

namespace FreelancerSdk\Resources\Projects;

use FreelancerSdk\Session;
use RuntimeException;

/**
 * Base class for Projects resources.
 */
class ProjectsBase
{
    protected Session $session;

    protected string $endpoint = 'api/projects/0.1';

    /**
     * Bind the resource to a Session for performing API requests.
     *
     * @param Session $session Session used to perform HTTP requests to the API.
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Send a GET request to the projects API path and return the decoded JSON response.
     *
     * @param string $path Path segment appended to the base API endpoint.
     * @param array  $params Query parameters to include in the request.
     * @return array Decoded JSON response as an associative array.
     * @throws \RuntimeException If the response body is not valid JSON.
     */
    protected function makeGetRequest(string $path, array $params = []): array
    {
        $url      = $this->endpoint . '/' . $path . '/';
        $response = $this->session->getClient()->get($url, ['query' => $params]);
        $decoded  = json_decode($response->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $decoded;
    }

    /**
     * Send a POST request to the projects API and decode the JSON response.
     *
     * @param string $path API path segment appended to the base endpoint.
     * @param array  $data Request payload that will be JSON-encoded.
     * @return array Decoded JSON response as an associative array.
     * @throws RuntimeException If the response body is not valid JSON.
     */
    protected function makePostRequest(string $path, array $data = []): array
    {
        $url      = $this->endpoint . '/' . $path . '/';
        $response = $this->session->getClient()->post($url, ['json' => $data]);
        $decoded  = json_decode($response->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $decoded;
    }

    /**
     * Send a PUT request to the API at the given path and return the decoded JSON response.
     *
     * @param string $path API path suffix appended to the base endpoint.
     * @param array $data JSON-serializable data to include in the request body.
     * @param array $params Query parameters to include in the request URL.
     * @return array The response body decoded as an associative array.
     * @throws \RuntimeException If the response body is not valid JSON.
     */
    protected function makePutRequest(string $path, array $data = [], array $params = []): array
    {
        $url     = $this->endpoint . '/' . $path . '/';
        $options = [];
        if (! empty($data)) {
            $options['json'] = $data;
        }
        if (! empty($params)) {
            $options['query'] = $params;
        }
        $response = $this->session->getClient()->put($url, $options);
        $decoded  = json_decode($response->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $decoded;
    }

    /**
     * Perform a DELETE request against the projects API and return the decoded JSON response.
     *
     * @param string $path   API path relative to the class endpoint (appended to the base endpoint).
     * @param array  $params Query parameters to include with the request.
     * @return array The response decoded from JSON into an associative array.
     * @throws \RuntimeException If the response body cannot be parsed as valid JSON.
     */
    protected function makeDeleteRequest(string $path, array $params = []): array
    {
        $url     = $this->endpoint . '/' . $path . '/';
        $options = [];
        if (! empty($params)) {
            $options['query'] = $params;
        }
        $response = $this->session->getClient()->delete($url, $options);
        $decoded  = json_decode($response->getBody()->getContents(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $decoded;
    }
}