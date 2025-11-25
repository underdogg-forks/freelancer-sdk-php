<?php

declare(strict_types=1);

namespace FreelancerSdk\Resources;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Users resource class
 * Handles all user-related API operations.
 */
class Users extends BaseResource
{
    private const ENDPOINT = 'api/users/0.1';

    /**
     * Retrieve details for the currently authenticated user.
     *
     * Forces a compact response by setting `'compact' => true` on the query parameters.
     *
     * @param array<string,mixed> $userDetails Optional query parameters to modify the response.
     * @return array<string,mixed> The authenticated user's details.
     * @throws GuzzleException If the HTTP request fails.
     */
    public function getSelf(array $userDetails = []): array
    {
        $userDetails['compact'] = true;
        return $this->fetchResult('/self/', $userDetails, 'Failed to get self user');
    }

    /**
     * Retrieve a user's compact profile by user ID.
     *
     * @param int $userId The ID of the user to fetch.
     * @param array<string,mixed> $userDetails Optional query parameters; the `compact` parameter will be set to `true`.
     * @return array<string,mixed> The user's profile data.
     * @throws GuzzleException
     */
    public function getUserById(int $userId, array $userDetails = []): array
    {
        $userDetails['compact'] = true;
        return $this->fetchResult('/users/' . $userId . '/', $userDetails, 'Failed to get user');
    }

    /**
         * Retrieve users that match the provided query parameters.
         *
         * @param array<string, mixed> $query Query parameters to filter, sort, or paginate the user list.
         * @return array<string, mixed> The API response `result` containing user data.
         * @throws GuzzleException
         */
    public function getUsers(array $query): array
    {
        return $this->fetchResult('/users/', $query, 'Failed to get users');
    }

    /**
     * Search freelancers using the users directory endpoint.
     *
     * @param array<string,mixed> $searchData Query parameters to send to the directory search.
     * @return array<string,mixed> The API `result` payload containing matching freelancers.
     * @throws \GuzzleHttp\Exception\GuzzleException If the HTTP request fails.
     * @throws \RuntimeException If the API response is not successful or does not contain a `result`.
     */
    public function searchFreelancers(array $searchData): array
    {
        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/users/directory/',
            ['query' => $searchData]
        );

        $data = $this->decodeJsonResponse($response);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to search freelancers');
    }

    /**
     * Retrieve reputations matching the provided query parameters.
     *
     * @param array<string, mixed> $query Query parameters to send to the reputations endpoint.
     * @return array<string, mixed> The `result` data returned by the API.
     * @throws GuzzleException When the HTTP client encounters an error.
     * @throws \RuntimeException When the API response is not successful or does not contain a `result`.
     */
    public function getReputations(array $query): array
    {
        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/reputations/',
            ['query' => $query]
        );

        $data = $this->decodeJsonResponse($response);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to get reputations');
    }

    /**
     * Retrieve user portfolios from the API.
     *
     * @param array<string,mixed> $query Query parameters to send with the request (filters, pagination, etc.).
     * @return array<string,mixed> The decoded API `result` array containing portfolios.
     * @throws GuzzleException If the HTTP client encounters a transport error.
     * @throws \RuntimeException If the API responds with an error or missing result.
     */
    public function getPortfolios(array $query): array
    {
        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/portfolios/',
            ['query' => $query]
        );

        $data = $this->decodeJsonResponse($response);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to get portfolios');
    }

    /**
     * Compatibility wrapper to retrieve a user's profile by user ID.
     *
     * @param int $userId The user identifier.
     * @return array The user's details as an associative array.
     * @deprecated Use {@see self::getUserById()} instead.
     */
    public function getUserProfile(int $userId): array
    {
        return $this->getUserById($userId);
    }

    /**
         * Retrieve the decoded `result` payload from the users API endpoint or raise an error.
         *
         * Performs an HTTP GET to the users endpoint path with the provided query parameters,
         * decodes the JSON response, and returns the `result` element when present.
         *
         * @param string $path Relative path appended to the users API endpoint.
         * @param array<string,mixed> $query Query parameters to include in the request.
         * @param string $defaultError Default error message used when the response does not provide one.
         * @return array<string,mixed> The decoded `result` field from the API response.
         * @throws GuzzleException When the HTTP client request fails.
         * @throws \RuntimeException When the response is not successful or does not contain a `result`.
         */
    private function fetchResult(string $path, array $query, string $defaultError): array
    {
        $response = $this->session->getClient()->get(
            self::ENDPOINT . $path,
            ['query' => $query]
        );

        $data = $this->decodeJsonResponse($response);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        $message = is_array($data) && isset($data['message']) ? $data['message'] : $defaultError;
        throw new \RuntimeException($message);
    }
}
