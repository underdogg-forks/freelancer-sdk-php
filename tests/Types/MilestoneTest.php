<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Types;

use FreelancerSdk\Types\Milestone;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the Milestone model class.
 */
class MilestoneTest extends TestCase
{
    /**
     * Test that a Milestone can be instantiated with an empty array.
     */
    #[Test]
    public function it_can_instantiate_with_empty_array(): void
    {
        $milestone = new Milestone([]);
        
        $this->assertInstanceOf(Milestone::class, $milestone);
    }

    /**
     * Test that a Milestone can be instantiated with data.
     */
    #[Test]
    public function it_can_instantiate_with_data(): void
    {
        $data = [
            'id' => 12345,
            'project_id' => 67890,
            'amount' => 250.50,
            'description' => 'First milestone payment',
            'status' => 'active',
        ];

        $milestone = new Milestone($data);

        $this->assertInstanceOf(Milestone::class, $milestone);
    }

    /**
     * Test magic __get retrieves data correctly.
     */
    #[Test]
    public function it_magic_get_retrieves_data(): void
    {
        $data = [
            'id' => 123,
            'project_id' => 456,
            'amount' => 100.0,
            'description' => 'Test milestone',
        ];

        $milestone = new Milestone($data);

        $this->assertSame(123, $milestone->id);
        $this->assertSame(456, $milestone->project_id);
        $this->assertSame(100.0, $milestone->amount);
        $this->assertSame('Test milestone', $milestone->description);
    }

    /**
     * Test magic __get returns null for nonexistent fields.
     */
    #[Test]
    public function it_magic_get_returns_null_for_nonexistent_fields(): void
    {
        $milestone = new Milestone(['id' => 123]);

        $this->assertNull($milestone->nonexistent_field);
        $this->assertNull($milestone->missing);
    }

    /**
     * Test magic __set updates data correctly.
     */
    #[Test]
    public function it_magic_set_updates_data(): void
    {
        $milestone = new Milestone(['id' => 123]);

        $milestone->amount = 500.0;
        $milestone->description = 'Updated description';

        $this->assertSame(500.0, $milestone->amount);
        $this->assertSame('Updated description', $milestone->description);
    }

    /**
     * Test magic __isset checks for field existence.
     */
    #[Test]
    public function it_magic_isset_checks_field_existence(): void
    {
        $milestone = new Milestone([
            'id' => 123,
            'amount' => 100.0,
        ]);

        $this->assertTrue(isset($milestone->id));
        $this->assertTrue(isset($milestone->amount));
        $this->assertFalse(isset($milestone->nonexistent));
    }

    /**
     * Test magic __isset handles null values correctly.
     */
    #[Test]
    public function it_magic_isset_handles_null_values(): void
    {
        $milestone = new Milestone([
            'id' => 123,
            'amount' => null,
        ]);

        $this->assertTrue(isset($milestone->id));
        $this->assertFalse(isset($milestone->amount));
    }

    /**
     * Test toArray returns the underlying data.
     */
    #[Test]
    public function it_to_array_returns_underlying_data(): void
    {
        $data = [
            'id' => 999,
            'project_id' => 888,
            'amount' => 750.0,
            'status' => 'pending',
        ];

        $milestone = new Milestone($data);

        $this->assertSame($data, $milestone->toArray());
    }

    /**
     * Test toArray returns empty array when instantiated with empty array.
     */
    #[Test]
    public function it_to_array_returns_empty_array_when_empty(): void
    {
        $milestone = new Milestone([]);

        $this->assertSame([], $milestone->toArray());
    }

    /**
     * Test that modifications via __set are reflected in toArray.
     */
    #[Test]
    public function it_modifications_reflected_in_to_array(): void
    {
        $milestone = new Milestone(['id' => 123]);

        $milestone->amount = 300.0;
        $milestone->status = 'paid';

        $array = $milestone->toArray();

        $this->assertSame(123, $array['id']);
        $this->assertSame(300.0, $array['amount']);
        $this->assertSame('paid', $array['status']);
    }

    /**
     * Test handling of complex nested data structures.
     */
    #[Test]
    public function it_handles_complex_nested_data(): void
    {
        $data = [
            'id' => 12345,
            'project_id' => 67890,
            'amount' => 1500.0,
            'currency' => [
                'id' => 1,
                'code' => 'USD',
                'sign' => '$',
            ],
            'bidder' => [
                'id' => 111,
                'username' => 'john_doe',
            ],
        ];

        $milestone = new Milestone($data);

        $this->assertSame(12345, $milestone->id);
        $this->assertSame(['id' => 1, 'code' => 'USD', 'sign' => '$'], $milestone->currency);
        $this->assertSame(['id' => 111, 'username' => 'john_doe'], $milestone->bidder);
    }

    /**
     * Test handling of array values.
     */
    #[Test]
    public function it_handles_array_values(): void
    {
        $data = [
            'id' => 123,
            'tags' => ['urgent', 'priority'],
            'metadata' => ['key1' => 'value1', 'key2' => 'value2'],
        ];

        $milestone = new Milestone($data);

        $this->assertSame(['urgent', 'priority'], $milestone->tags);
        $this->assertSame(['key1' => 'value1', 'key2' => 'value2'], $milestone->metadata);
    }

    /**
     * Test handling of boolean values.
     */
    #[Test]
    public function it_handles_boolean_values(): void
    {
        $data = [
            'id' => 123,
            'is_paid' => true,
            'is_disputed' => false,
        ];

        $milestone = new Milestone($data);

        $this->assertTrue($milestone->is_paid);
        $this->assertFalse($milestone->is_disputed);
    }

    /**
     * Test handling of numeric edge cases.
     */
    #[Test]
    public function it_handles_numeric_edge_cases(): void
    {
        $data = [
            'id' => 0,
            'amount' => 0.0,
            'project_id' => PHP_INT_MAX,
            'large_amount' => 999999999.99,
        ];

        $milestone = new Milestone($data);

        $this->assertSame(0, $milestone->id);
        $this->assertSame(0.0, $milestone->amount);
        $this->assertSame(PHP_INT_MAX, $milestone->project_id);
        $this->assertSame(999999999.99, $milestone->large_amount);
    }

    /**
     * Test handling of string values with special characters.
     */
    #[Test]
    public function it_handles_string_with_special_characters(): void
    {
        $data = [
            'id' => 123,
            'description' => "Test with 'quotes' and \"double quotes\"",
            'notes' => "Line 1\nLine 2\nLine 3",
        ];

        $milestone = new Milestone($data);

        $this->assertSame("Test with 'quotes' and \"double quotes\"", $milestone->description);
        $this->assertSame("Line 1\nLine 2\nLine 3", $milestone->notes);
    }

    /**
     * Test handling of empty string values.
     */
    #[Test]
    public function it_handles_empty_strings(): void
    {
        $data = [
            'id' => 123,
            'description' => '',
            'notes' => '',
        ];

        $milestone = new Milestone($data);

        $this->assertSame('', $milestone->description);
        $this->assertSame('', $milestone->notes);
    }

    /**
     * Test comprehensive milestone with all typical fields.
     */
    #[Test]
    public function it_comprehensive_milestone_data(): void
    {
        $data = [
            'id' => 12345,
            'project_id' => 67890,
            'bidder_id' => 54321,
            'amount' => 1250.75,
            'description' => 'Complete the frontend development',
            'status' => 'requested',
            'time_created' => 1609459200,
            'time_requested' => 1609545600,
            'transaction_id' => 'TXN123456',
            'reason' => 2,
        ];

        $milestone = new Milestone($data);

        $this->assertSame(12345, $milestone->id);
        $this->assertSame(67890, $milestone->project_id);
        $this->assertSame(54321, $milestone->bidder_id);
        $this->assertSame(1250.75, $milestone->amount);
        $this->assertSame('Complete the frontend development', $milestone->description);
        $this->assertSame('requested', $milestone->status);
        $this->assertSame(1609459200, $milestone->time_created);
        $this->assertSame(1609545600, $milestone->time_requested);
        $this->assertSame('TXN123456', $milestone->transaction_id);
        $this->assertSame(2, $milestone->reason);
    }

    /**
     * Test that original data is not modified by mutations.
     */
    #[Test]
    public function it_original_data_not_modified_by_mutations(): void
    {
        $originalData = ['id' => 123, 'amount' => 100.0];
        $milestone = new Milestone($originalData);

        // Modify via magic setter
        $milestone->amount = 200.0;

        // Original array should remain unchanged
        $this->assertSame(100.0, $originalData['amount']);

        // But the milestone object should have the new value
        $this->assertSame(200.0, $milestone->amount);
    }

    /**
     * Test multiple field updates in sequence.
     */
    #[Test]
    public function it_multiple_field_updates_in_sequence(): void
    {
        $milestone = new Milestone(['id' => 1]);

        $milestone->amount = 100.0;
        $this->assertSame(100.0, $milestone->amount);

        $milestone->amount = 200.0;
        $this->assertSame(200.0, $milestone->amount);

        $milestone->status = 'active';
        $this->assertSame('active', $milestone->status);

        $milestone->status = 'completed';
        $this->assertSame('completed', $milestone->status);
    }

    /**
     * Test accessing fields in different ways.
     */
    #[Test]
    public function it_accessing_fields_in_different_ways(): void
    {
        $milestone = new Milestone(['id' => 123, 'amount' => 100.0]);

        // Via magic getter
        $this->assertSame(123, $milestone->id);

        // Via toArray
        $array = $milestone->toArray();
        $this->assertSame(123, $array['id']);
        $this->assertSame(100.0, $array['amount']);
    }
}