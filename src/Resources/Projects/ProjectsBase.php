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

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Make a GET request to the API.
     *
     * @param string $path
     * @param array  $params
     *
     * @return array
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
     * Make a POST request to the API.
     *
     * @param string $path
     * @param array  $data
     *
     * @return array
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
     * Make a PUT request to the API.
     *
     * @param string $path
     * @param array  $data
     * @param array  $params
     *
     * @return array
     */
    protected function makePutRequest(string $path, array $data = [], array $params = []): array
    {
        $url     = $this->endpoint . '/' . $path . '/';
        $options = [];
        if ( ! empty($data)) {
            $options['json'] = $data;
        }
        if ( ! empty($params)) {
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
     * Make a DELETE request to the API.
     *
     * @param string $path
     * @param array  $params
     *
     * @return array
     */
    protected function makeDeleteRequest(string $path, array $params = []): array
    {
        $url     = $this->endpoint . '/' . $path . '/';
        $options = [];
        if ( ! empty($params)) {
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
