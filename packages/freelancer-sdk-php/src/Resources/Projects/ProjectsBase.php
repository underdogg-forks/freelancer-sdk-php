<?php

namespace FreelancerSdk\Resources\Projects;

use FreelancerSdk\Session;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Base class for Projects resources
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
     * Make a GET request to the API
     *
     * @param string $path
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    protected function makeGetRequest(string $path, array $params = []): array
    {
        $url = $this->endpoint . '/' . $path . '/';
        $response = $this->session->getClient()->get($url, ['query' => $params]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Make a POST request to the API
     *
     * @param string $path
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    protected function makePostRequest(string $path, array $data = []): array
    {
        $url = $this->endpoint . '/' . $path . '/';
        $response = $this->session->getClient()->post($url, ['json' => $data]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Make a PUT request to the API
     *
     * @param string $path
     * @param array $data
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    protected function makePutRequest(string $path, array $data = [], array $params = []): array
    {
        $url = $this->endpoint . '/' . $path . '/';
        $options = [];
        if (!empty($data)) {
            $options['json'] = $data;
        }
        if (!empty($params)) {
            $options['query'] = $params;
        }
        $response = $this->session->getClient()->put($url, $options);
        return json_decode($response->getBody()->getContents(), true);
    }
}
