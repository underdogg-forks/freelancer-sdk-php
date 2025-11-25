<?php

declare(strict_types=1);

namespace FreelancerSdk\Resources\Contests;

use FreelancerSdk\Exceptions\Contests\ContestNotCreatedException;
use FreelancerSdk\Resources\BaseResource;
use FreelancerSdk\Types\Contest;
use GuzzleHttp\Exception\GuzzleException;

class Contests extends BaseResource
{
    private const ENDPOINT = 'api/contests/0.1';

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

            $data = $this->decodeJsonResponse($response);

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
