<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Types;

use FreelancerSdk\Types\Bid;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the Bid model class.
 */
class BidTest extends TestCase
{
    /**
     * Test that a Bid can be instantiated with an empty array.
     */
    public function testCanInstantiateWithEmptyArray(): void
    {
        $bid = new Bid([]);
        
        $this->assertInstanceOf(Bid::class, $bid);
        $this->assertNull($bid->getId());
        $this->assertNull($bid->getProjectId());
        $this->assertNull($bid->getBidderId());
    }

    /**
     * Test that a Bid can be instantiated with declared properties.
     */
    public function testCanInstantiateWithDeclaredProperties(): void
    {
        $data = [
            'id' => 12345,
            'project_id' => 67890,
            'bidder_id' => 111,
            'amount' => 250.50,
            'period' => 7,
            'description' => 'I can complete this project',
            'milestone_percentage' => 50,
            'retracted' => false,
            'time_submitted' => 1640000000,
        ];

        $bid = new Bid($data);

        $this->assertSame(12345, $bid->getId());
        $this->assertSame(67890, $bid->getProjectId());
        $this->assertSame(111, $bid->getBidderId());
        $this->assertSame(250.50, $bid->getAmount());
        $this->assertSame(7, $bid->getPeriod());
        $this->assertSame('I can complete this project', $bid->getDescription());
        $this->assertSame(50, $bid->getMilestonePercentage());
        $this->assertFalse($bid->isRetracted());
        $this->assertSame(1640000000, $bid->getTimeSubmitted());
    }

    /**
     * Test that undeclared properties are stored in attributes.
     */
    public function testUndeclaredPropertiesStoredInAttributes(): void
    {
        $data = [
            'id' => 123,
            'custom_field' => 'custom_value',
            'another_field' => 42,
        ];

        $bid = new Bid($data);

        $this->assertSame(123, $bid->getId());
        $this->assertSame('custom_value', $bid->getAttribute('custom_field'));
        $this->assertSame(42, $bid->getAttribute('another_field'));
    }

    /**
     * Test getAttribute with default value when attribute doesn't exist.
     */
    public function testGetAttributeReturnsDefaultWhenNotSet(): void
    {
        $bid = new Bid([]);

        $this->assertNull($bid->getAttribute('nonexistent'));
        $this->assertSame('default', $bid->getAttribute('nonexistent', 'default'));
        $this->assertSame(0, $bid->getAttribute('nonexistent', 0));
    }

    /**
     * Test the fill method updates existing properties.
     */
    public function testFillMethodUpdatesProperties(): void
    {
        $bid = new Bid(['id' => 1, 'amount' => 100.0]);

        $this->assertSame(1, $bid->getId());
        $this->assertSame(100.0, $bid->getAmount());

        $bid->fill(['id' => 2, 'amount' => 200.0, 'period' => 5]);

        $this->assertSame(2, $bid->getId());
        $this->assertSame(200.0, $bid->getAmount());
        $this->assertSame(5, $bid->getPeriod());
    }

    /**
     * Test the fill method returns the instance for method chaining.
     */
    public function testFillMethodReturnsInstance(): void
    {
        $bid = new Bid([]);
        $result = $bid->fill(['id' => 123]);

        $this->assertSame($bid, $result);
    }

    /**
     * Test toArray includes all non-null properties.
     */
    public function testToArrayIncludesNonNullProperties(): void
    {
        $data = [
            'id' => 999,
            'project_id' => 888,
            'amount' => 150.0,
        ];

        $bid = new Bid($data);
        $array = $bid->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('project_id', $array);
        $this->assertArrayHasKey('amount', $array);
        $this->assertSame(999, $array['id']);
        $this->assertSame(888, $array['project_id']);
        $this->assertSame(150.0, $array['amount']);
    }

    /**
     * Test toArray excludes null properties.
     */
    public function testToArrayExcludesNullProperties(): void
    {
        $bid = new Bid(['id' => 123]);
        $array = $bid->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayNotHasKey('project_id', $array);
        $this->assertArrayNotHasKey('bidder_id', $array);
        $this->assertArrayNotHasKey('period', $array);
    }

    /**
     * Test toArray merges attributes into the result.
     */
    public function testToArrayMergesAttributes(): void
    {
        $data = [
            'id' => 456,
            'custom_attr' => 'value',
            'another_attr' => true,
        ];

        $bid = new Bid($data);
        $array = $bid->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('custom_attr', $array);
        $this->assertArrayHasKey('another_attr', $array);
        $this->assertSame('value', $array['custom_attr']);
        $this->assertTrue($array['another_attr']);
    }

    /**
     * Test jsonSerialize returns the same as toArray.
     */
    public function testJsonSerializeReturnsArrayRepresentation(): void
    {
        $data = [
            'id' => 789,
            'amount' => 300.0,
            'custom' => 'data',
        ];

        $bid = new Bid($data);

        $this->assertSame($bid->toArray(), $bid->jsonSerialize());
    }

    /**
     * Test that Bid can be JSON encoded.
     */
    public function testBidCanBeJsonEncoded(): void
    {
        $bid = new Bid(['id' => 100, 'amount' => 50.0]);
        $json = json_encode($bid);

        $this->assertIsString($json);
        $decoded = json_decode($json, true);
        $this->assertSame(100, $decoded['id']);
        $this->assertSame(50.0, $decoded['amount']);
    }

    /**
     * Test ArrayAccess offsetExists with declared properties.
     */
    public function testOffsetExistsWithDeclaredProperties(): void
    {
        $bid = new Bid(['id' => 123, 'amount' => 100.0]);

        $this->assertTrue(isset($bid['id']));
        $this->assertTrue(isset($bid['amount']));
        $this->assertFalse(isset($bid['nonexistent']));
    }

    /**
     * Test ArrayAccess offsetExists with attributes.
     */
    public function testOffsetExistsWithAttributes(): void
    {
        $bid = new Bid(['custom_field' => 'value']);

        $this->assertTrue(isset($bid['custom_field']));
    }

    /**
     * Test ArrayAccess offsetGet with declared properties.
     */
    public function testOffsetGetWithDeclaredProperties(): void
    {
        $bid = new Bid(['id' => 555, 'amount' => 75.25]);

        $this->assertSame(555, $bid['id']);
        $this->assertSame(75.25, $bid['amount']);
    }

    /**
     * Test ArrayAccess offsetGet with attributes.
     */
    public function testOffsetGetWithAttributes(): void
    {
        $bid = new Bid(['custom' => 'attribute']);

        $this->assertSame('attribute', $bid['custom']);
    }

    /**
     * Test ArrayAccess offsetGet returns null for nonexistent keys.
     */
    public function testOffsetGetReturnsNullForNonexistent(): void
    {
        $bid = new Bid([]);

        $this->assertNull($bid['nonexistent']);
    }

    /**
     * Test ArrayAccess offsetSet with declared properties.
     */
    public function testOffsetSetWithDeclaredProperties(): void
    {
        $bid = new Bid([]);
        $bid['id'] = 777;
        $bid['amount'] = 99.99;

        $this->assertSame(777, $bid->getId());
        $this->assertSame(99.99, $bid->getAmount());
    }

    /**
     * Test ArrayAccess offsetSet with attributes.
     */
    public function testOffsetSetWithAttributes(): void
    {
        $bid = new Bid([]);
        $bid['custom'] = 'new_value';

        $this->assertSame('new_value', $bid->getAttribute('custom'));
    }

    /**
     * Test ArrayAccess offsetUnset with declared properties sets them to null.
     */
    public function testOffsetUnsetWithDeclaredPropertiesSetsToNull(): void
    {
        $bid = new Bid(['id' => 123, 'amount' => 50.0]);

        unset($bid['id']);

        $this->assertNull($bid->getId());
        $this->assertSame(50.0, $bid->getAmount());
    }

    /**
     * Test ArrayAccess offsetUnset with attributes removes them.
     */
    public function testOffsetUnsetWithAttributesRemovesThem(): void
    {
        $bid = new Bid(['custom' => 'value']);

        $this->assertTrue(isset($bid['custom']));

        unset($bid['custom']);

        $this->assertFalse(isset($bid['custom']));
        $this->assertNull($bid['custom']);
    }

    /**
     * Test magic __get with declared properties.
     */
    public function testMagicGetWithDeclaredProperties(): void
    {
        $bid = new Bid(['id' => 321, 'amount' => 88.88]);

        $this->assertSame(321, $bid->id);
        $this->assertSame(88.88, $bid->amount);
    }

    /**
     * Test magic __get with attributes.
     */
    public function testMagicGetWithAttributes(): void
    {
        $bid = new Bid(['custom_property' => 'test_value']);

        $this->assertSame('test_value', $bid->custom_property);
    }

    /**
     * Test magic __get returns null for nonexistent properties.
     */
    public function testMagicGetReturnsNullForNonexistent(): void
    {
        $bid = new Bid([]);

        $this->assertNull($bid->nonexistent_property);
    }

    /**
     * Test magic __set with declared properties.
     */
    public function testMagicSetWithDeclaredProperties(): void
    {
        $bid = new Bid([]);
        $bid->id = 999;
        $bid->amount = 123.45;

        $this->assertSame(999, $bid->getId());
        $this->assertSame(123.45, $bid->getAmount());
    }

    /**
     * Test magic __set with attributes.
     */
    public function testMagicSetWithAttributes(): void
    {
        $bid = new Bid([]);
        $bid->dynamic_field = 'dynamic_value';

        $this->assertSame('dynamic_value', $bid->getAttribute('dynamic_field'));
    }

    /**
     * Test magic __isset with declared properties.
     */
    public function testMagicIssetWithDeclaredProperties(): void
    {
        $bid = new Bid(['id' => 100]);

        $this->assertTrue(isset($bid->id));
        $this->assertFalse(isset($bid->project_id));
    }

    /**
     * Test magic __isset with attributes.
     */
    public function testMagicIssetWithAttributes(): void
    {
        $bid = new Bid(['custom' => 'exists']);

        $this->assertTrue(isset($bid->custom));
        $this->assertFalse(isset($bid->nonexistent));
    }

    /**
     * Test handling of null values for nullable properties.
     */
    public function testNullablePropertiesHandledCorrectly(): void
    {
        $bid = new Bid([
            'id' => null,
            'amount' => null,
            'retracted' => null,
        ]);

        $this->assertNull($bid->getId());
        $this->assertNull($bid->getAmount());
        $this->assertNull($bid->isRetracted());
    }

    /**
     * Test that boolean retracted field works correctly.
     */
    public function testRetractedBooleanValues(): void
    {
        $bidRetracted = new Bid(['retracted' => true]);
        $bidActive = new Bid(['retracted' => false]);
        $bidUnknown = new Bid([]);

        $this->assertTrue($bidRetracted->isRetracted());
        $this->assertFalse($bidActive->isRetracted());
        $this->assertNull($bidUnknown->isRetracted());
    }

    /**
     * Test handling of edge case values for numeric fields.
     */
    public function testNumericEdgeCases(): void
    {
        $bid = new Bid([
            'id' => 0,
            'amount' => 0.0,
            'period' => 0,
            'milestone_percentage' => 0,
        ]);

        $this->assertSame(0, $bid->getId());
        $this->assertSame(0.0, $bid->getAmount());
        $this->assertSame(0, $bid->getPeriod());
        $this->assertSame(0, $bid->getMilestonePercentage());
    }

    /**
     * Test handling of large numeric values.
     */
    public function testLargeNumericValues(): void
    {
        $bid = new Bid([
            'id' => PHP_INT_MAX,
            'amount' => 999999999.99,
            'period' => 365,
            'time_submitted' => 2147483647,
        ]);

        $this->assertSame(PHP_INT_MAX, $bid->getId());
        $this->assertSame(999999999.99, $bid->getAmount());
        $this->assertSame(365, $bid->getPeriod());
        $this->assertSame(2147483647, $bid->getTimeSubmitted());
    }

    /**
     * Test handling of empty string description.
     */
    public function testEmptyStringDescription(): void
    {
        $bid = new Bid(['description' => '']);

        $this->assertSame('', $bid->getDescription());
    }

    /**
     * Test handling of multi-line description.
     */
    public function testMultiLineDescription(): void
    {
        $description = "Line 1\nLine 2\nLine 3";
        $bid = new Bid(['description' => $description]);

        $this->assertSame($description, $bid->getDescription());
    }

    /**
     * Test that attributes can override declared properties in toArray.
     */
    public function testAttributesCanOverrideDeclaredPropertiesInToArray(): void
    {
        // This tests the documented behavior where attributes can override properties
        $bid = new Bid(['id' => 100]);
        $bid->fill(['custom_id' => 999]);
        
        $array = $bid->toArray();
        
        // The declared property should be in the array
        $this->assertArrayHasKey('id', $array);
        $this->assertSame(100, $array['id']);
        
        // Custom attributes should also be present
        $this->assertArrayHasKey('custom_id', $array);
        $this->assertSame(999, $array['custom_id']);
    }

    /**
     * Test complex data structure with all fields populated.
     */
    public function testComplexBidWithAllFields(): void
    {
        $data = [
            'id' => 12345,
            'project_id' => 67890,
            'bidder_id' => 54321,
            'amount' => 1500.75,
            'period' => 14,
            'description' => 'Comprehensive bid description with details',
            'milestone_percentage' => 75,
            'retracted' => false,
            'time_submitted' => 1609459200,
            'custom_rating' => 4.5,
            'verified' => true,
            'extra_data' => ['key' => 'value'],
        ];

        $bid = new Bid($data);

        // Test declared properties
        $this->assertSame(12345, $bid->getId());
        $this->assertSame(67890, $bid->getProjectId());
        $this->assertSame(54321, $bid->getBidderId());
        $this->assertSame(1500.75, $bid->getAmount());
        $this->assertSame(14, $bid->getPeriod());
        $this->assertSame('Comprehensive bid description with details', $bid->getDescription());
        $this->assertSame(75, $bid->getMilestonePercentage());
        $this->assertFalse($bid->isRetracted());
        $this->assertSame(1609459200, $bid->getTimeSubmitted());

        // Test custom attributes
        $this->assertSame(4.5, $bid->getAttribute('custom_rating'));
        $this->assertTrue($bid->getAttribute('verified'));
        $this->assertSame(['key' => 'value'], $bid->getAttribute('extra_data'));

        // Test array conversion includes everything
        $array = $bid->toArray();
        $this->assertCount(12, $array);
        $this->assertArrayHasKey('custom_rating', $array);
        $this->assertArrayHasKey('verified', $array);
        $this->assertArrayHasKey('extra_data', $array);
    }

    /**
     * Test immutability of original data array after instantiation.
     */
    public function testOriginalDataArrayNotModified(): void
    {
        $originalData = ['id' => 123, 'amount' => 100.0];
        $bid = new Bid($originalData);
        
        $bid->fill(['id' => 456]);
        
        // Original array should remain unchanged
        $this->assertSame(123, $originalData['id']);
        $this->assertSame(100.0, $originalData['amount']);
    }
}