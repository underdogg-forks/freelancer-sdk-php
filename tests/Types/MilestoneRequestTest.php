<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Types;

use FreelancerSdk\Types\MilestoneRequest;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the MilestoneRequest model class.
 */
class MilestoneRequestTest extends TestCase
{
    /**
     * Test that a MilestoneRequest can be instantiated with an empty array.
     */
    #[Test]
    public function it_can_instantiate_with_empty_array(): void
    {
        $request = new MilestoneRequest([]);

        $this->assertInstanceOf(MilestoneRequest::class, $request);
    }

    /**
     * Test that a MilestoneRequest can be instantiated with data.
     */
    #[Test]
    public function it_can_instantiate_with_data(): void
    {
        $data = [
            'id'          => 12345,
            'project_id'  => 67890,
            'amount'      => 500.0,
            'description' => 'Milestone payment request',
        ];

        $request = new MilestoneRequest($data);

        $this->assertInstanceOf(MilestoneRequest::class, $request);
    }

    /**
     * Test magic __get retrieves data correctly.
     */
    #[Test]
    public function it_magic_get_retrieves_data(): void
    {
        $data = [
            'id'          => 123,
            'project_id'  => 456,
            'amount'      => 250.0,
            'description' => 'Test request',
            'status'      => 'pending',
        ];

        $request = new MilestoneRequest($data);

        $this->assertSame(123, $request->id);
        $this->assertSame(456, $request->project_id);
        $this->assertSame(250.0, $request->amount);
        $this->assertSame('Test request', $request->description);
        $this->assertSame('pending', $request->status);
    }

    /**
     * Test magic __get returns null for nonexistent fields.
     */
    #[Test]
    public function it_magic_get_returns_null_for_nonexistent_fields(): void
    {
        $request = new MilestoneRequest(['id' => 123]);

        $this->assertNull($request->nonexistent_field);
        $this->assertNull($request->missing_data);
    }

    /**
     * Test magic __set updates data correctly.
     */
    #[Test]
    public function it_magic_set_updates_data(): void
    {
        $request = new MilestoneRequest(['id' => 123]);

        $request->amount      = 750.0;
        $request->description = 'Updated request description';
        $request->status      = 'approved';

        $this->assertSame(750.0, $request->amount);
        $this->assertSame('Updated request description', $request->description);
        $this->assertSame('approved', $request->status);
    }

    /**
     * Test magic __isset checks for field existence.
     */
    #[Test]
    public function it_magic_isset_checks_field_existence(): void
    {
        $request = new MilestoneRequest([
            'id'     => 123,
            'amount' => 100.0,
            'status' => 'pending',
        ]);

        $this->assertTrue(isset($request->id));
        $this->assertTrue(isset($request->amount));
        $this->assertTrue(isset($request->status));
        $this->assertFalse(isset($request->nonexistent));
    }

    /**
     * Test magic __isset handles null values correctly.
     */
    #[Test]
    public function it_magic_isset_handles_null_values(): void
    {
        $request = new MilestoneRequest([
            'id'          => 123,
            'amount'      => null,
            'description' => null,
        ]);

        $this->assertTrue(isset($request->id));
        $this->assertFalse(isset($request->amount));
        $this->assertFalse(isset($request->description));
    }

    /**
     * Test toArray returns the underlying data.
     */
    #[Test]
    public function it_to_array_returns_underlying_data(): void
    {
        $data = [
            'id'          => 999,
            'project_id'  => 888,
            'amount'      => 1250.0,
            'description' => 'Final payment request',
            'status'      => 'accepted',
        ];

        $request = new MilestoneRequest($data);

        $this->assertSame($data, $request->toArray());
    }

    /**
     * Test toArray returns empty array when instantiated with empty array.
     */
    #[Test]
    public function it_to_array_returns_empty_array_when_empty(): void
    {
        $request = new MilestoneRequest([]);

        $this->assertSame([], $request->toArray());
    }

    /**
     * Test that modifications via __set are reflected in toArray.
     */
    #[Test]
    public function it_modifications_reflected_in_to_array(): void
    {
        $request = new MilestoneRequest(['id' => 123]);

        $request->amount = 500.0;
        $request->status = 'approved';
        $request->notes  = 'Approved by manager';

        $array = $request->toArray();

        $this->assertSame(123, $array['id']);
        $this->assertSame(500.0, $array['amount']);
        $this->assertSame('approved', $array['status']);
        $this->assertSame('Approved by manager', $array['notes']);
    }

    /**
     * Test handling of complex nested data structures.
     */
    #[Test]
    public function it_handles_complex_nested_data(): void
    {
        $data = [
            'id'         => 12345,
            'project_id' => 67890,
            'amount'     => 2000.0,
            'bidder'     => [
                'id'       => 111,
                'username' => 'freelancer_joe',
            ],
            'currency' => [
                'id'   => 1,
                'code' => 'USD',
            ],
        ];

        $request = new MilestoneRequest($data);

        $this->assertSame(12345, $request->id);
        $this->assertSame(['id' => 111, 'username' => 'freelancer_joe'], $request->bidder);
        $this->assertSame(['id' => 1, 'code' => 'USD'], $request->currency);
    }

    /**
     * Test handling of array values.
     */
    #[Test]
    public function it_handles_array_values(): void
    {
        $data = [
            'id'          => 123,
            'attachments' => ['file1.pdf', 'file2.doc'],
            'metadata'    => ['key' => 'value', 'priority' => 'high'],
        ];

        $request = new MilestoneRequest($data);

        $this->assertSame(['file1.pdf', 'file2.doc'], $request->attachments);
        $this->assertSame(['key' => 'value', 'priority' => 'high'], $request->metadata);
    }

    /**
     * Test handling of boolean values.
     */
    #[Test]
    public function it_handles_boolean_values(): void
    {
        $data = [
            'id'              => 123,
            'is_approved'     => true,
            'is_rejected'     => false,
            'requires_review' => true,
        ];

        $request = new MilestoneRequest($data);

        $this->assertTrue($request->is_approved);
        $this->assertFalse($request->is_rejected);
        $this->assertTrue($request->requires_review);
    }

    /**
     * Test handling of numeric edge cases.
     */
    #[Test]
    public function it_handles_numeric_edge_cases(): void
    {
        $data = [
            'id'           => 0,
            'amount'       => 0.0,
            'project_id'   => PHP_INT_MAX,
            'large_amount' => 9999999.99,
        ];

        $request = new MilestoneRequest($data);

        $this->assertSame(0, $request->id);
        $this->assertSame(0.0, $request->amount);
        $this->assertSame(PHP_INT_MAX, $request->project_id);
        $this->assertSame(9999999.99, $request->large_amount);
    }

    /**
     * Test handling of string values with special characters.
     */
    #[Test]
    public function it_handles_string_with_special_characters(): void
    {
        $data = [
            'id'          => 123,
            'description' => "Payment for 'Phase 1' & \"Phase 2\"",
            'notes'       => "Line 1\nLine 2\nTab\tSeparated",
        ];

        $request = new MilestoneRequest($data);

        $this->assertSame("Payment for 'Phase 1' & \"Phase 2\"", $request->description);
        $this->assertSame("Line 1\nLine 2\nTab\tSeparated", $request->notes);
    }

    /**
     * Test handling of empty strings.
     */
    #[Test]
    public function it_handles_empty_strings(): void
    {
        $data = [
            'id'          => 123,
            'description' => '',
            'notes'       => '',
        ];

        $request = new MilestoneRequest($data);

        $this->assertSame('', $request->description);
        $this->assertSame('', $request->notes);
    }

    /**
     * Test comprehensive milestone request with all typical fields.
     */
    #[Test]
    public function it_comprehensive_milestone_request_data(): void
    {
        $data = [
            'id'             => 12345,
            'project_id'     => 67890,
            'bidder_id'      => 54321,
            'amount'         => 1500.0,
            'description'    => 'Request for milestone payment upon completion',
            'status'         => 'requested',
            'time_created'   => 1609459200,
            'time_requested' => 1609545600,
            'reason'         => 'Work completed as per agreement',
            'request_type'   => 'release',
        ];

        $request = new MilestoneRequest($data);

        $this->assertSame(12345, $request->id);
        $this->assertSame(67890, $request->project_id);
        $this->assertSame(54321, $request->bidder_id);
        $this->assertSame(1500.0, $request->amount);
        $this->assertSame('Request for milestone payment upon completion', $request->description);
        $this->assertSame('requested', $request->status);
        $this->assertSame(1609459200, $request->time_created);
        $this->assertSame(1609545600, $request->time_requested);
        $this->assertSame('Work completed as per agreement', $request->reason);
        $this->assertSame('release', $request->request_type);
    }

    /**
     * Test that original data is not modified by mutations.
     */
    #[Test]
    public function it_original_data_not_modified_by_mutations(): void
    {
        $originalData = ['id' => 123, 'amount' => 100.0, 'status' => 'pending'];
        $request      = new MilestoneRequest($originalData);

        // Modify via magic setter
        $request->amount = 200.0;
        $request->status = 'approved';

        // Original array should remain unchanged
        $this->assertSame(100.0, $originalData['amount']);
        $this->assertSame('pending', $originalData['status']);

        // But the request object should have the new values
        $this->assertSame(200.0, $request->amount);
        $this->assertSame('approved', $request->status);
    }

    /**
     * Test multiple field updates in sequence.
     */
    #[Test]
    public function it_multiple_field_updates_in_sequence(): void
    {
        $request = new MilestoneRequest(['id' => 1]);

        $request->amount = 100.0;
        $this->assertSame(100.0, $request->amount);

        $request->amount = 200.0;
        $this->assertSame(200.0, $request->amount);

        $request->status = 'pending';
        $this->assertSame('pending', $request->status);

        $request->status = 'approved';
        $this->assertSame('approved', $request->status);

        $request->status = 'completed';
        $this->assertSame('completed', $request->status);
    }

    /**
     * Test different request statuses.
     */
    #[Test]
    public function it_different_request_statuses(): void
    {
        $pendingRequest  = new MilestoneRequest(['id' => 1, 'status' => 'pending']);
        $approvedRequest = new MilestoneRequest(['id' => 2, 'status' => 'approved']);
        $rejectedRequest = new MilestoneRequest(['id' => 3, 'status' => 'rejected']);

        $this->assertSame('pending', $pendingRequest->status);
        $this->assertSame('approved', $approvedRequest->status);
        $this->assertSame('rejected', $rejectedRequest->status);
    }

    /**
     * Test accessing fields in different ways.
     */
    #[Test]
    public function it_accessing_fields_in_different_ways(): void
    {
        $request = new MilestoneRequest(['id' => 123, 'amount' => 500.0, 'status' => 'pending']);

        // Via magic getter
        $this->assertSame(123, $request->id);
        $this->assertSame(500.0, $request->amount);

        // Via toArray
        $array = $request->toArray();
        $this->assertSame(123, $array['id']);
        $this->assertSame(500.0, $array['amount']);
        $this->assertSame('pending', $array['status']);
    }
}
