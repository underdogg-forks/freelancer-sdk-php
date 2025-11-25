<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Resources\Enums;

use FreelancerSdk\Resources\Enums\ProjectType;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the ProjectType enum.
 */
class ProjectTypeTest extends TestCase
{
    /**
     * Test that all expected enum cases exist.
     */
    public function testAllEnumCasesExist(): void
    {
        $this->assertTrue(enum_exists(ProjectType::class));
        
        $cases = ProjectType::cases();
        $this->assertCount(2, $cases);
        
        $caseNames = array_map(fn($case) => $case->name, $cases);
        $this->assertContains('FIXED', $caseNames);
        $this->assertContains('HOURLY', $caseNames);
    }

    /**
     * Test enum case values.
     */
    public function testEnumCaseValues(): void
    {
        $this->assertSame(0, ProjectType::FIXED->value);
        $this->assertSame(1, ProjectType::HOURLY->value);
    }

    /**
     * Test from() method creates enum from value.
     */
    public function testFromMethodCreatesEnumFromValue(): void
    {
        $this->assertSame(ProjectType::FIXED, ProjectType::from(0));
        $this->assertSame(ProjectType::HOURLY, ProjectType::from(1));
    }

    /**
     * Test tryFrom() method.
     */
    public function testTryFromMethod(): void
    {
        $this->assertSame(ProjectType::FIXED, ProjectType::tryFrom(0));
        $this->assertNull(ProjectType::tryFrom(999));
    }
}