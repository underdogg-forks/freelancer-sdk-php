<?php

declare(strict_types=1);

namespace FreelancerSdk\Resources;

use FreelancerSdk\Session;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Users resource class
 * Handles all user-related API operations.
 */
class Users
{
    private const ENDPOINT = 'api/users/0.1';

    public function __construct(
        private readonly Session $session
    ) {
    }

    /**
     * Get details about the currently authenticated user
     *
     * @param  array<string, mixed>  $userDetails
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getSelf(array $userDetails = []): array
    {
        $userDetails['compact'] = true;

        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/self/',
            ['query' => $userDetails]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to get self user');
    }

    /**
     * Get details about a specific user
     *
     * @param  int  $userId
     * @param  array<string, mixed>  $userDetails
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getUserById(int $userId, array $userDetails = []): array
    {
        $userDetails['compact'] = true;

        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/users/' . $userId . '/',
            ['query' => $userDetails]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to get user');
    }

    /**
     * Get one or more users
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getUsers(array $query): array
    {
        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/users/',
            ['query' => $query]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to get users');
    }

    /**
     * Search for freelancers
     *
     * @param  array<string, mixed>  $searchData
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function searchFreelancers(array $searchData): array
    {
        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/users/directory/',
            ['query' => $searchData]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to search freelancers');
    }

    /**
     * Get user reputations
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getReputations(array $query): array
    {
        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/reputations/',
            ['query' => $query]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to get reputations');
    }

    /**
     * Get user portfolios
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getPortfolios(array $query): array
    {
        $response = $this->session->getClient()->get(
            self::ENDPOINT . '/portfolios/',
            ['query' => $query]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === 200 && isset($data['result'])) {
            return $data['result'];
        }

        throw new \RuntimeException($data['message'] ?? 'Failed to get portfolios');
    }

    // Deprecated method for backward compatibility
    public function getUserProfile(int $userId): array
    {
        return $this->getUserById($userId);
    }
}
