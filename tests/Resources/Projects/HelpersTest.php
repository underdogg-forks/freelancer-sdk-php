<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Resources\Projects;

use FreelancerSdk\Resources\Projects\Helpers;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the Helpers class.
 */
class HelpersTest extends TestCase
{
    /**
     * Test createCurrencyObject with only required parameters.
     */
    #[Test]
    public function it_create_currency_object_with_only_id(): void
    {
        $currency = Helpers::createCurrencyObject(1);

        $this->assertIsArray($currency);
        $this->assertArrayHasKey('id', $currency);
        $this->assertSame(1, $currency['id']);
        $this->assertCount(1, $currency);
    }

    /**
     * Test createCurrencyObject with all parameters.
     */
    #[Test]
    public function it_create_currency_object_with_all_parameters(): void
    {
        $currency = Helpers::createCurrencyObject(
            1,
            'USD',
            '$',
            'US Dollar',
            1.0,
            'United States'
        );

        $this->assertIsArray($currency);
        $this->assertSame(1, $currency['id']);
        $this->assertSame('USD', $currency['code']);
        $this->assertSame('$', $currency['sign']);
        $this->assertSame('US Dollar', $currency['name']);
        $this->assertSame(1.0, $currency['exchange_rate']);
        $this->assertSame('United States', $currency['country']);
        $this->assertCount(6, $currency);
    }

    /**
     * Test createCurrencyObject with some optional parameters.
     */
    #[Test]
    public function it_create_currency_object_with_some_parameters(): void
    {
        $currency = Helpers::createCurrencyObject(2, 'EUR', '€');

        $this->assertSame(2, $currency['id']);
        $this->assertSame('EUR', $currency['code']);
        $this->assertSame('€', $currency['sign']);
        $this->assertArrayNotHasKey('name', $currency);
        $this->assertArrayNotHasKey('exchange_rate', $currency);
        $this->assertArrayNotHasKey('country', $currency);
    }

    /**
     * Test createJobObject with only required parameter.
     */
    #[Test]
    public function it_create_job_object_with_only_id(): void
    {
        $job = Helpers::createJobObject(10);

        $this->assertIsArray($job);
        $this->assertArrayHasKey('id', $job);
        $this->assertSame(10, $job['id']);
        $this->assertCount(1, $job);
    }

    /**
     * Test createJobObject with all parameters.
     */
    #[Test]
    public function it_create_job_object_with_all_parameters(): void
    {
        $category = ['id' => 5, 'name' => 'Programming'];
        $seoInfo  = ['title' => 'PHP Jobs', 'description' => 'Find PHP jobs'];

        $job = Helpers::createJobObject(
            10,
            'PHP Development',
            $category,
            125,
            'php-development',
            $seoInfo
        );

        $this->assertIsArray($job);
        $this->assertSame(10, $job['id']);
        $this->assertSame('PHP Development', $job['name']);
        $this->assertSame($category, $job['category']);
        $this->assertSame(125, $job['active_project_count']);
        $this->assertSame('php-development', $job['seo_url']);
        $this->assertSame($seoInfo, $job['seo_info']);
        $this->assertCount(6, $job);
    }

    /**
     * Test createBudgetObject with only required parameter.
     */
    #[Test]
    public function it_create_budget_object_with_only_minimum(): void
    {
        $budget = Helpers::createBudgetObject(100.0);

        $this->assertIsArray($budget);
        $this->assertArrayHasKey('minimum', $budget);
        $this->assertSame(100.0, $budget['minimum']);
        $this->assertCount(1, $budget);
    }

    /**
     * Test createBudgetObject with all parameters.
     */
    #[Test]
    public function it_create_budget_object_with_all_parameters(): void
    {
        $budget = Helpers::createBudgetObject(
            100.0,
            500.0,
            'Small Project',
            'fixed',
            1
        );

        $this->assertIsArray($budget);
        $this->assertSame(100.0, $budget['minimum']);
        $this->assertSame(500.0, $budget['maximum']);
        $this->assertSame('Small Project', $budget['name']);
        $this->assertSame('fixed', $budget['project_type']);
        $this->assertSame(1, $budget['currency_id']);
        $this->assertCount(5, $budget);
    }

    /**
     * Test createHourlyProjectInfoObject with valid parameters.
     */
    #[Test]
    public function it_create_hourly_project_info_object(): void
    {
        $info = Helpers::createHourlyProjectInfoObject(40, 'week');

        $this->assertIsArray($info);
        $this->assertArrayHasKey('commitment', $info);
        $this->assertIsArray($info['commitment']);
        $this->assertArrayHasKey('hours', $info['commitment']);
        $this->assertArrayHasKey('interval', $info['commitment']);
        $this->assertSame(40, $info['commitment']['hours']);
        $this->assertSame('week', $info['commitment']['interval']);
    }

    /**
     * Test createLocationObject with no parameters.
     */
    #[Test]
    public function it_create_location_object_with_no_parameters(): void
    {
        $location = Helpers::createLocationObject();

        $this->assertIsArray($location);
        $this->assertEmpty($location);
    }

    /**
     * Test createLocationObject with all parameters.
     */
    #[Test]
    public function it_create_location_object_with_all_parameters(): void
    {
        $country = ['id' => 1, 'code' => 'US', 'name' => 'United States'];

        $location = Helpers::createLocationObject(
            $country,
            'New York',
            40.7128,
            -74.0060,
            'Manhattan',
            'NY',
            '123 Main St, New York, NY 10001'
        );

        $this->assertIsArray($location);
        $this->assertSame($country, $location['country']);
        $this->assertSame('New York', $location['city']);
        $this->assertSame(40.7128, $location['latitude']);
        $this->assertSame(-74.0060, $location['longitude']);
        $this->assertSame('Manhattan', $location['vicinity']);
        $this->assertSame('NY', $location['administrative_area']);
        $this->assertSame('123 Main St, New York, NY 10001', $location['full_address']);
        $this->assertCount(7, $location);
    }

    /**
     * Test createBidObject with all parameters.
     */
    #[Test]
    public function it_create_bid_object(): void
    {
        $bid = Helpers::createBidObject(
            12345,
            111,
            67890,
            false,
            250.50,
            7,
            'I can complete this project',
            222
        );

        $this->assertIsArray($bid);
        $this->assertSame(12345, $bid['id']);
        $this->assertSame(111, $bid['bidder_id']);
        $this->assertSame(67890, $bid['project_id']);
        $this->assertFalse($bid['retracted']);
        $this->assertSame(250.50, $bid['amount']);
        $this->assertSame(7, $bid['period']);
        $this->assertSame('I can complete this project', $bid['description']);
        $this->assertSame(222, $bid['project_owner_id']);
        $this->assertCount(8, $bid);
    }

    /**
     * Test that helper methods are all static.
     */
    #[Test]
    public function it_helper_methods_are_static(): void
    {
        $reflection = new \ReflectionClass(Helpers::class);
        $methods    = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $this->assertTrue(
                $method->isStatic(),
                "Method {$method->getName()} should be static"
            );
        }
    }
}
