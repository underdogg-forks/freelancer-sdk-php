<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Exceptions\Contests\ContestNotCreatedException;
use FreelancerSdk\Resources\Contests\Contests;
use PHPUnit\Framework\Attributes\Test;

class ContestsTest extends BaseTestCase
{
    #[Test]
    public function it_creates_a_contest(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'id'          => 201,
                'owner_id'    => 101,
                'title'       => 'Design a logo',
                'description' => 'I need a logo for my company',
                'type'        => 'freemium',
                'duration'    => 7,
                'jobs'        => [
                    ['id' => 1, 'name' => 'Graphic Design'],
                    ['id' => 2, 'name' => 'Logo Design'],
                ],
                'currency' => ['id' => 1, 'code' => 'USD'],
                'prize'    => 100,
            ])
        );

        $contests    = new Contests($session);
        $contestData = [
            'title'       => 'Design a logo',
            'description' => 'I need a logo for my company',
            'type'        => 'freemium',
            'duration'    => 7,
            'job_ids'     => [1, 2],
            'currency_id' => 1,
            'prize'       => 100,
        ];

        $contest = $contests->createContest($contestData);

        $this->assertSame(201, $contest->id);
        $this->assertSame('Design a logo', $contest->title);
        $this->assertSame('freemium', $contest->type);
        $this->assertEquals(100, $contest->prize);
    }

    #[Test]
    public function it_throws_exception_when_contest_creation_fails(): void
    {
        $session  = $this->createMockSession($this->createErrorResponse());
        $contests = new Contests($session);

        $this->expectException(ContestNotCreatedException::class);
        $this->expectExceptionMessage('An error has occurred.');

        $contests->createContest([
            'title'       => 'Design a logo',
            'description' => 'I need a logo',
            'type'        => 'freemium',
            'duration'    => 7,
            'job_ids'     => [1, 2],
            'currency_id' => 1,
            'prize'       => 100,
        ]);
    }
}
