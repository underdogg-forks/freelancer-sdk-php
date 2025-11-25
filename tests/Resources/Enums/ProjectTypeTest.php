<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Resources\Enums;

use FreelancerSdk\Resources\Enums\ProjectType;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the ProjectType enum.
 */
class ProjectTypeTest extends TestCase
{
    /**
     * Test that all expected enum cases exist.
     */
    #[Test]
    public function it_has_all_expected_enum_cases(): void
    {
        $this->assertTrue(enum_exists(ProjectType::class));

        $cases = ProjectType::cases();
        $this->assertCount(2, $cases);

        $caseNames = array_map(fn ($case) => $case->name, $cases);
        $this->assertContains('FIXED', $caseNames);
        $this->assertContains('HOURLY', $caseNames);
    }

    /**
     * Test enum case values.
     */
    #[Test]
    public function it_has_correct_enum_case_values(): void
    {
        $this->assertSame(0, ProjectType::FIXED->value);
        $this->assertSame(1, ProjectType::HOURLY->value);
    }

    /**
     * Test from() method creates enum from value.
     */
    #[Test]
    public function it_creates_enum_from_value_using_from_method(): void
    {
        $this->assertSame(ProjectType::FIXED, ProjectType::from(0));
        $this->assertSame(ProjectType::HOURLY, ProjectType::from(1));
    }

    /**
     * Test tryFrom() method.
     */
    #[Test]
    public function it_returns_null_for_invalid_value_using_try_from(): void
    {
        $this->assertSame(ProjectType::FIXED, ProjectType::tryFrom(0));
        $this->assertNull(ProjectType::tryFrom(999));
    }
}
