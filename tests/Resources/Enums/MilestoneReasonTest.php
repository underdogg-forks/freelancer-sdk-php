<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Resources\Enums;

use FreelancerSdk\Resources\Enums\MilestoneReason;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the MilestoneReason enum.
 */
class MilestoneReasonTest extends TestCase
{
    /**
     * Test that all expected enum cases exist.
     */
    #[Test]
    public function it_has_all_expected_enum_cases(): void
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
    #[Test]
    public function it_has_correct_enum_case_values(): void
    {
        $this->assertSame(0, MilestoneReason::FULL_PAYMENT->value);
        $this->assertSame(1, MilestoneReason::PARTIAL_PAYMENT->value);
        $this->assertSame(2, MilestoneReason::TASK_DESCRIPTION->value);
        $this->assertSame(3, MilestoneReason::OTHER->value);
    }

    /**
     * Test from() method creates enum from value.
     */
    #[Test]
    public function it_creates_enum_from_value_using_from_method(): void
    {
        $this->assertSame(MilestoneReason::FULL_PAYMENT, MilestoneReason::from(0));
        $this->assertSame(MilestoneReason::PARTIAL_PAYMENT, MilestoneReason::from(1));
        $this->assertSame(MilestoneReason::TASK_DESCRIPTION, MilestoneReason::from(2));
        $this->assertSame(MilestoneReason::OTHER, MilestoneReason::from(3));
    }

    /**
     * Test tryFrom() method.
     */
    #[Test]
    public function it_returns_null_for_invalid_value_using_try_from(): void
    {
        $this->assertSame(MilestoneReason::FULL_PAYMENT, MilestoneReason::tryFrom(0));
        $this->assertNull(MilestoneReason::tryFrom(999));
    }
}