<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Types;

use FreelancerSdk\Types\Service;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the Service model class.
 */
class ServiceTest extends TestCase
{
    /**
     * Test that a Service can be instantiated with an empty array.
     */
    public function testCanInstantiateWithEmptyArray(): void
    {
        $service = new Service([]);
        
        $this->assertInstanceOf(Service::class, $service);
    }

    /**
     * Test that a Service can be instantiated with data.
     */
    public function testCanInstantiateWithData(): void
    {
        $data = [
            'id' => 12345,
            'name' => 'Web Development',
            'category' => 'Technology',
        ];

        $service = new Service($data);

        $this->assertInstanceOf(Service::class, $service);
    }

    /**
     * Test magic __get retrieves data correctly.
     */
    public function testMagicGetRetrievesData(): void
    {
        $data = [
            'id' => 123,
            'name' => 'Logo Design',
            'category' => 'Design',
            'price' => 150.0,
            'description' => 'Professional logo design service',
        ];

        $service = new Service($data);

        $this->assertSame(123, $service->id);
        $this->assertSame('Logo Design', $service->name);
        $this->assertSame('Design', $service->category);
        $this->assertSame(150.0, $service->price);
        $this->assertSame('Professional logo design service', $service->description);
    }

    /**
     * Test magic __get returns null for nonexistent fields.
     */
    public function testMagicGetReturnsNullForNonexistentFields(): void
    {
        $service = new Service(['id' => 123]);

        $this->assertNull($service->nonexistent_field);
        $this->assertNull($service->missing_data);
        $this->assertNull($service->undefined);
    }

    /**
     * Test toArray returns the underlying data.
     */
    public function testToArrayReturnsUnderlyingData(): void
    {
        $data = [
            'id' => 999,
            'name' => 'Mobile App Development',
            'price' => 5000.0,
            'duration' => 30,
        ];

        $service = new Service($data);

        $this->assertSame($data, $service->toArray());
    }

    /**
     * Test toArray returns empty array when instantiated with empty array.
     */
    public function testToArrayReturnsEmptyArrayWhenEmpty(): void
    {
        $service = new Service([]);

        $this->assertSame([], $service->toArray());
    }

    /**
     * Test handling of complex nested data structures.
     */
    public function testHandlesComplexNestedData(): void
    {
        $data = [
            'id' => 12345,
            'name' => 'Full Stack Development',
            'pricing' => [
                'basic' => 1000.0,
                'standard' => 2500.0,
                'premium' => 5000.0,
            ],
            'features' => [
                'basic' => ['Frontend', 'Backend'],
                'standard' => ['Frontend', 'Backend', 'Database'],
                'premium' => ['Frontend', 'Backend', 'Database', 'Deployment', 'Support'],
            ],
        ];

        $service = new Service($data);

        $this->assertSame(12345, $service->id);
        $this->assertSame('Full Stack Development', $service->name);
        $this->assertSame(['basic' => 1000.0, 'standard' => 2500.0, 'premium' => 5000.0], $service->pricing);
        $this->assertIsArray($service->features);
        $this->assertArrayHasKey('basic', $service->features);
        $this->assertArrayHasKey('premium', $service->features);
    }

    /**
     * Test handling of array values.
     */
    public function testHandlesArrayValues(): void
    {
        $data = [
            'id' => 123,
            'tags' => ['web', 'design', 'responsive'],
            'technologies' => ['HTML', 'CSS', 'JavaScript'],
            'categories' => [10, 20, 30],
        ];

        $service = new Service($data);

        $this->assertSame(['web', 'design', 'responsive'], $service->tags);
        $this->assertSame(['HTML', 'CSS', 'JavaScript'], $service->technologies);
        $this->assertSame([10, 20, 30], $service->categories);
    }

    /**
     * Test handling of boolean values.
     */
    public function testHandlesBooleanValues(): void
    {
        $data = [
            'id' => 123,
            'is_active' => true,
            'is_featured' => false,
            'requires_approval' => true,
        ];

        $service = new Service($data);

        $this->assertTrue($service->is_active);
        $this->assertFalse($service->is_featured);
        $this->assertTrue($service->requires_approval);
    }

    /**
     * Test handling of numeric edge cases.
     */
    public function testHandlesNumericEdgeCases(): void
    {
        $data = [
            'id' => 0,
            'price' => 0.0,
            'large_id' => PHP_INT_MAX,
            'expensive_price' => 999999.99,
        ];

        $service = new Service($data);

        $this->assertSame(0, $service->id);
        $this->assertSame(0.0, $service->price);
        $this->assertSame(PHP_INT_MAX, $service->large_id);
        $this->assertSame(999999.99, $service->expensive_price);
    }

    /**
     * Test handling of string values with special characters.
     */
    public function testHandlesStringWithSpecialCharacters(): void
    {
        $data = [
            'id' => 123,
            'name' => "Web Development & Design",
            'description' => "Professional 'full-stack' development",
            'notes' => "Line 1\nLine 2\tTabbed content",
        ];

        $service = new Service($data);

        $this->assertSame("Web Development & Design", $service->name);
        $this->assertSame("Professional 'full-stack' development", $service->description);
        $this->assertSame("Line 1\nLine 2\tTabbed content", $service->notes);
    }

    /**
     * Test handling of empty strings.
     */
    public function testHandlesEmptyStrings(): void
    {
        $data = [
            'id' => 123,
            'name' => '',
            'description' => '',
        ];

        $service = new Service($data);

        $this->assertSame('', $service->name);
        $this->assertSame('', $service->description);
    }

    /**
     * Test handling of null values.
     */
    public function testHandlesNullValues(): void
    {
        $data = [
            'id' => 123,
            'description' => null,
            'category' => null,
        ];

        $service = new Service($data);

        $this->assertSame(123, $service->id);
        $this->assertNull($service->description);
        $this->assertNull($service->category);
    }

    /**
     * Test comprehensive service data with all typical fields.
     */
    public function testComprehensiveServiceData(): void
    {
        $data = [
            'id' => 12345,
            'name' => 'Premium Web Development',
            'description' => 'Complete web development service including design and deployment',
            'category' => 'Web Development',
            'subcategory' => 'Full Stack',
            'price' => 2500.0,
            'currency' => 'USD',
            'duration' => 30,
            'duration_unit' => 'days',
            'freelancer_id' => 67890,
            'rating' => 4.9,
            'reviews_count' => 87,
            'orders_count' => 145,
            'is_active' => true,
            'delivery_time' => 7,
        ];

        $service = new Service($data);

        $this->assertSame(12345, $service->id);
        $this->assertSame('Premium Web Development', $service->name);
        $this->assertSame('Complete web development service including design and deployment', $service->description);
        $this->assertSame('Web Development', $service->category);
        $this->assertSame('Full Stack', $service->subcategory);
        $this->assertSame(2500.0, $service->price);
        $this->assertSame('USD', $service->currency);
        $this->assertSame(30, $service->duration);
        $this->assertSame('days', $service->duration_unit);
        $this->assertSame(67890, $service->freelancer_id);
        $this->assertSame(4.9, $service->rating);
        $this->assertSame(87, $service->reviews_count);
        $this->assertSame(145, $service->orders_count);
        $this->assertTrue($service->is_active);
        $this->assertSame(7, $service->delivery_time);
    }

    /**
     * Test accessing fields in different ways.
     */
    public function testAccessingFieldsInDifferentWays(): void
    {
        $service = new Service(['id' => 123, 'name' => 'Test Service', 'price' => 100.0]);

        // Via magic getter
        $this->assertSame(123, $service->id);
        $this->assertSame('Test Service', $service->name);

        // Via toArray
        $array = $service->toArray();
        $this->assertSame(123, $array['id']);
        $this->assertSame('Test Service', $array['name']);
        $this->assertSame(100.0, $array['price']);
    }

    /**
     * Test that Service data is immutable from external modifications.
     */
    public function testServiceDataImmutableFromExternalModifications(): void
    {
        $originalData = ['id' => 123, 'name' => 'Original Service'];
        $service = new Service($originalData);

        // Modify the original array
        $originalData['name'] = 'Modified Service';
        $originalData['new_field'] = 'new_value';

        // Service should still have original data
        $this->assertSame('Original Service', $service->name);
        $this->assertNull($service->new_field);
    }

    /**
     * Test Service with minimal required data.
     */
    public function testServiceWithMinimalData(): void
    {
        $service = new Service(['id' => 1]);

        $this->assertSame(1, $service->id);
        $this->assertNull($service->name);
        $this->assertNull($service->price);
    }

    /**
     * Test Service with pricing tiers.
     */
    public function testServiceWithPricingTiers(): void
    {
        $data = [
            'id' => 123,
            'name' => 'Design Service',
            'tiers' => [
                [
                    'name' => 'Basic',
                    'price' => 50.0,
                    'features' => ['1 concept', '2 revisions'],
                ],
                [
                    'name' => 'Premium',
                    'price' => 150.0,
                    'features' => ['3 concepts', 'unlimited revisions', 'source files'],
                ],
            ],
        ];

        $service = new Service($data);

        $this->assertSame(123, $service->id);
        $this->assertIsArray($service->tiers);
        $this->assertCount(2, $service->tiers);
        $this->assertSame('Basic', $service->tiers[0]['name']);
        $this->assertSame(150.0, $service->tiers[1]['price']);
    }

    /**
     * Test Service with large dataset.
     */
    public function testServiceWithLargeDataset(): void
    {
        $data = ['id' => 1];
        for ($i = 0; $i < 50; $i++) {
            $data["attribute_$i"] = "value_$i";
        }

        $service = new Service($data);

        for ($i = 0; $i < 50; $i++) {
            $this->assertSame("value_$i", $service->{"attribute_$i"});
        }

        $this->assertCount(51, $service->toArray());
    }
}