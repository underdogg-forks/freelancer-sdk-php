<?php

declare(strict_types=1);

namespace FreelancerSdk\Resources\Contests;

use FreelancerSdk\Exceptions\Contests\ContestNotCreatedException;
use FreelancerSdk\Session;
use FreelancerSdk\Types\Contest;
use GuzzleHttp\Exception\GuzzleException;

class Contests
{
    private const ENDPOINT = 'api/contests/0.1';

    /**
     * Create a Contests resource bound to the provided Session for API requests.
     *
     * @param Session $session HTTP session used to send requests to the Freelancer API.
     */
    public function __construct(
        private readonly Session $session
    ) {
    }

    /**
     * Creates a contest via the Freelancer API.
     *
     * Sends the provided contest data to the contests endpoint and returns the created Contest on success.
     *
     * @param array{title: string, description: string, type: string, duration: int, job_ids: array<int>, currency_id: int, prize: float} $contestData Contest payload with keys:
     *     - title: contest title
     *     - description: contest description
     *     - type: contest type identifier
     *     - duration: duration in days
     *     - job_ids: related job IDs
     *     - currency_id: currency identifier
     *     - prize: prize amount
     * @return Contest The created Contest instance constructed from the API response `result`.
     * @throws ContestNotCreatedException If the API returns invalid JSON, an unexpected response format, an error payload, or if the HTTP request fails.
     */
    public function createContest(array $contestData): Contest
    {
        try {
            $response = $this->session->getClient()->post(
                self::ENDPOINT . '/contests/',
                ['json' => $contestData]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            // Validate JSON decode result
            if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
                throw new ContestNotCreatedException(
                    'Invalid JSON response from API: ' . json_last_error_msg(),
                    null,
                    null
                );
            }

            if (!is_array($data)) {
                throw new ContestNotCreatedException(
                    'Unexpected response format from API',
                    null,
                    null
                );
            }

            if ($response->getStatusCode() === 200 && isset($data['result'])) {
                return new Contest($data['result']);
            }

            throw new ContestNotCreatedException(
                $data['message']    ?? 'Failed to create contest',
                $data['error_code'] ?? null,
                $data['request_id'] ?? null
            );
        } catch (GuzzleException $e) {
            throw new ContestNotCreatedException(
                'Failed to create contest: ' . $e->getMessage(),
                null,
                null,
                $e->getCode(),
                $e
            );
        }
    }
}