<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Resources\Users;
use PHPUnit\Framework\Attributes\Test;

class UsersTest extends BaseTestCase
{
    #[Test]
    public function it_gets_users(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'users' => [
                    '100' => ['status' => null, 'id' => 100],
                    '200' => ['status' => null, 'id' => 200],
                ],
            ])
        );

        $users  = new Users($session);
        $result = $users->getUsers(['users[]' => [100, 200]]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('users', $result);
        $this->assertCount(2, $result['users']);
    }

    #[Test]
    public function it_gets_user_by_id(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'id'       => 100,
                'username' => 'creativedesign',
            ])
        );

        $users  = new Users($session);
        $result = $users->getUserById(100, ['country' => true, 'status' => true]);

        $this->assertIsArray($result);
        $this->assertSame(100, $result['id']);
        $this->assertSame('creativedesign', $result['username']);
    }

    #[Test]
    public function it_gets_self_user(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse(['id' => 100])
        );

        $users  = new Users($session);
        $result = $users->getSelf(['country' => true, 'status' => true]);

        $this->assertIsArray($result);
        $this->assertSame(100, $result['id']);
    }

    #[Test]
    public function it_searches_freelancers(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'users' => [
                    '100' => [
                        'status'   => null,
                        'id'       => 100,
                        'username' => 'creativedesign',
                    ],
                ],
            ])
        );

        $users  = new Users($session);
        $result = $users->searchFreelancers([
            'query'   => 'designer',
            'limit'   => 10,
            'offset'  => 0,
            'compact' => true,
            'country' => true,
            'status'  => true,
        ]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('users', $result);
        $this->assertCount(1, $result['users']);
    }

    #[Test]
    public function it_gets_reputations(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                '1' => [
                    'user_id'     => 1,
                    'last3months' => ['completion_rate' => 0.75, 'all' => 4],
                ],
                '2' => [
                    'user_id'     => 2,
                    'last3months' => ['completion_rate' => 0.99, 'all' => 7],
                ],
                '3' => [
                    'user_id'     => 3,
                    'last3months' => ['completion_rate' => 0.88, 'all' => 10],
                ],
            ])
        );

        $users  = new Users($session);
        $result = $users->getReputations([
            'users[]'       => [1, 2, 3],
            'jobs[]'        => [],
            'role'          => 'freelancer',
            'job_history'   => true,
            'project_stats' => true,
            'rehire_rates'  => true,
        ]);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
    }

    #[Test]
    public function it_gets_portfolios(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'portfolios' => [
                    '1' => [
                        [
                            'files' => [
                                ['description' => 'hello', 'filename' => 'Hello.flv', 'id' => 2000],
                            ],
                            'articles'    => [],
                            'user_id'     => 1,
                            'description' => 'hello!',
                        ],
                        [
                            'files' => [
                                ['description' => 'hi', 'filename' => 'Hi.jpg', 'id' => 2001],
                            ],
                            'articles'    => [],
                            'user_id'     => 1,
                            'description' => 'hi!',
                        ],
                    ],
                ],
            ])
        );

        $users  = new Users($session);
        $result = $users->getPortfolios([
            'users[]' => [1],
            'limit'   => 10,
            'offset'  => 0,
        ]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('portfolios', $result);
        $this->assertCount(1, $result['portfolios']);
        $this->assertCount(2, $result['portfolios']['1']);
    }
}
