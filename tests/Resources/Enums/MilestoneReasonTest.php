<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Resources\Enums;

use FreelancerSdk\Resources\Enums\MilestoneReason;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the MilestoneReason enum.
 */
class MilestoneReasonTest extends TestCase
{
    /**
     * Test that all expected enum cases exist.
     */
    public function testAllEnumCasesExist(): void
    {
        $this->assertTrue(enum_exists(MilestoneReason::class));
        
        $cases = MilestoneReason::cases();
        $this->assertCount(4, $cases);
        
        $caseNames = array_map(fn($case) => $case->name, $cases);
        $this->assertContains('FULL_PAYMENT', $caseNames);
        $this->assertContains('PARTIAL_PAYMENT', $caseNames);
        $this->assertContains('TASK_DESCRIPTION', $caseNames);
        $this->assertContains('OTHER', $caseNames);
    }

    /**
     * Test enum case values.
     */
    public function testEnumCaseValues(): void
    {
        $this->assertSame(0, MilestoneReason::FULL_PAYMENT->value);
        $this->assertSame(1, MilestoneReason::PARTIAL_PAYMENT->value);
        $this->assertSame(2, MilestoneReason::TASK_DESCRIPTION->value);
        $this->assertSame(3, MilestoneReason::OTHER->value);
    }

    /**
     * Test from() method creates enum from value.
     */
    public function testFromMethodCreatesEnumFromValue(): void
    {
        $this->assertSame(MilestoneReason::FULL_PAYMENT, MilestoneReason::from(0));
        $this->assertSame(MilestoneReason::PARTIAL_PAYMENT, MilestoneReason::from(1));
        $this->assertSame(MilestoneReason::TASK_DESCRIPTION, MilestoneReason::from(2));
        $this->assertSame(MilestoneReason::OTHER, MilestoneReason::from(3));
    }

    /**
     * Test tryFrom() method.
     */
    public function testTryFromMethod(): void
    {
        $this->assertSame(MilestoneReason::FULL_PAYMENT, MilestoneReason::tryFrom(0));
        $this->assertNull(MilestoneReason::tryFrom(999));
    }
}