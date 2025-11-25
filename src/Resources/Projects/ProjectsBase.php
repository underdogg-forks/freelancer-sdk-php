<?php

namespace FreelancerSdk\Resources\Projects;

use FreelancerSdk\Resources\BaseResource;

/**
 * Base class for Projects resources.
 */
class ProjectsBase extends BaseResource
{
    protected string $endpoint = 'api/projects/0.1';

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

        return $this->decodeJsonResponse($response);
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

        return $this->decodeJsonResponse($response);
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

        return $this->decodeJsonResponse($response);
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

        return $this->decodeJsonResponse($response);
    }
}