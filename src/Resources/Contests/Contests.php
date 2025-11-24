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

    public function __construct(
        private readonly Session $session
    ) {
    }

    /**
     * Create a contest
     *
     * @param  array{
     *     title: string,
     *     description: string,
     *     type: string,
     *     duration: int,
     *     job_ids: array<int>,
     *     currency_id: int,
     *     prize: float
     * } $contestData
     * @return Contest
     * @throws ContestNotCreatedException
     * @throws GuzzleException
     */
    public function createContest(array $contestData): Contest
    {
        try {
            $response = $this->session->getClient()->post(
                self::ENDPOINT . '/contests/',
                ['json' => $contestData]
            );

            $data = json_decode($response->getBody()->getContents(), true);

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
                null
            );
        }
    }
}
