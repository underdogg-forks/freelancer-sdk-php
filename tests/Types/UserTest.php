<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests\Types;

use FreelancerSdk\Types\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * Comprehensive unit tests for the User model class.
 */
class UserTest extends TestCase
{
    /**
     * Test that a User can be instantiated with an empty array.
     */
    #[Test]
    public function it_can_instantiate_with_empty_array(): void
    {
        $user = new User([]);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test that a User can be instantiated with data.
     */
    #[Test]
    public function it_can_instantiate_with_data(): void
    {
        $data = [
            'id'       => 12345,
            'username' => 'john_doe',
            'email'    => 'john@example.com',
        ];

        $user = new User($data);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test magic __get retrieves data correctly.
     */
    #[Test]
    public function it_magic_get_retrieves_data(): void
    {
        $data = [
            'id'           => 123,
            'username'     => 'freelancer_joe',
            'email'        => 'joe@freelancer.com',
            'display_name' => 'Joe Smith',
            'status'       => 'active',
        ];

        $user = new User($data);

        $this->assertSame(123, $user->id);
        $this->assertSame('freelancer_joe', $user->username);
        $this->assertSame('joe@freelancer.com', $user->email);
        $this->assertSame('Joe Smith', $user->display_name);
        $this->assertSame('active', $user->status);
    }

    /**
     * Test magic __get returns null for nonexistent fields.
     */
    #[Test]
    public function it_magic_get_returns_null_for_nonexistent_fields(): void
    {
        $user = new User(['id' => 123]);

        $this->assertNull($user->nonexistent_field);
        $this->assertNull($user->missing_data);
        $this->assertNull($user->undefined);
    }

    /**
     * Test toArray returns the underlying data.
     */
    #[Test]
    public function it_to_array_returns_underlying_data(): void
    {
        $data = [
            'id'       => 999,
            'username' => 'test_user',
            'email'    => 'test@example.com',
            'avatar'   => 'https://example.com/avatar.jpg',
        ];

        $user = new User($data);

        $this->assertSame($data, $user->toArray());
    }

    /**
     * Test toArray returns empty array when instantiated with empty array.
     */
    #[Test]
    public function it_to_array_returns_empty_array_when_empty(): void
    {
        $user = new User([]);

        $this->assertSame([], $user->toArray());
    }

    /**
     * Test handling of complex nested data structures.
     */
    #[Test]
    public function it_handles_complex_nested_data(): void
    {
        $data = [
            'id'       => 12345,
            'username' => 'john_doe',
            'profile'  => [
                'bio'    => 'Experienced developer',
                'skills' => ['PHP', 'JavaScript', 'Python'],
            ],
            'location' => [
                'country' => 'USA',
                'city'    => 'New York',
            ],
        ];

        $user = new User($data);

        $this->assertSame(12345, $user->id);
        $this->assertSame('john_doe', $user->username);
        $this->assertSame(['bio' => 'Experienced developer', 'skills' => ['PHP', 'JavaScript', 'Python']], $user->profile);
        $this->assertSame(['country' => 'USA', 'city' => 'New York'], $user->location);
    }

    /**
     * Test handling of array values.
     */
    #[Test]
    public function it_handles_array_values(): void
    {
        $data = [
            'id'       => 123,
            'skills'   => ['PHP', 'Laravel', 'Vue.js'],
            'badges'   => ['verified', 'premium'],
            'projects' => [1, 2, 3, 4, 5],
        ];

        $user = new User($data);

        $this->assertSame(['PHP', 'Laravel', 'Vue.js'], $user->skills);
        $this->assertSame(['verified', 'premium'], $user->badges);
        $this->assertSame([1, 2, 3, 4, 5], $user->projects);
    }

    /**
     * Test handling of boolean values.
     */
    #[Test]
    public function it_handles_boolean_values(): void
    {
        $data = [
            'id'              => 123,
            'is_verified'     => true,
            'is_active'       => false,
            'email_confirmed' => true,
        ];

        $user = new User($data);

        $this->assertTrue($user->is_verified);
        $this->assertFalse($user->is_active);
        $this->assertTrue($user->email_confirmed);
    }

    /**
     * Test handling of numeric edge cases.
     */
    #[Test]
    public function it_handles_numeric_edge_cases(): void
    {
        $data = [
            'id'       => 0,
            'rating'   => 0.0,
            'large_id' => PHP_INT_MAX,
            'balance'  => 9999999.99,
        ];

        $user = new User($data);

        $this->assertSame(0, $user->id);
        $this->assertSame(0.0, $user->rating);
        $this->assertSame(PHP_INT_MAX, $user->large_id);
        $this->assertSame(9999999.99, $user->balance);
    }

    /**
     * Test handling of string values with special characters.
     */
    #[Test]
    public function it_handles_string_with_special_characters(): void
    {
        $data = [
            'id'       => 123,
            'username' => 'user_with-special.chars',
            'bio'      => "I'm a developer & designer",
            'notes'    => "Line 1\nLine 2\tTabbed",
        ];

        $user = new User($data);

        $this->assertSame('user_with-special.chars', $user->username);
        $this->assertSame("I'm a developer & designer", $user->bio);
        $this->assertSame("Line 1\nLine 2\tTabbed", $user->notes);
    }

    /**
     * Test handling of empty strings.
     */
    #[Test]
    public function it_handles_empty_strings(): void
    {
        $data = [
            'id'       => 123,
            'username' => '',
            'bio'      => '',
        ];

        $user = new User($data);

        $this->assertSame('', $user->username);
        $this->assertSame('', $user->bio);
    }

    /**
     * Test handling of null values.
     */
    #[Test]
    public function it_handles_null_values(): void
    {
        $data = [
            'id'    => 123,
            'email' => null,
            'phone' => null,
        ];

        $user = new User($data);

        $this->assertSame(123, $user->id);
        $this->assertNull($user->email);
        $this->assertNull($user->phone);
    }

    /**
     * Test comprehensive user data with all typical fields.
     */
    #[Test]
    public function it_comprehensive_user_data(): void
    {
        $data = [
            'id'                 => 12345,
            'username'           => 'professional_dev',
            'email'              => 'dev@example.com',
            'display_name'       => 'Professional Developer',
            'first_name'         => 'Professional',
            'last_name'          => 'Developer',
            'status'             => 'active',
            'role'               => 'freelancer',
            'avatar'             => 'https://example.com/avatar.jpg',
            'rating'             => 4.8,
            'reviews_count'      => 125,
            'completed_projects' => 98,
            'country_code'       => 'US',
            'timezone'           => 'America/New_York',
            'member_since'       => 1577836800,
        ];

        $user = new User($data);

        $this->assertSame(12345, $user->id);
        $this->assertSame('professional_dev', $user->username);
        $this->assertSame('dev@example.com', $user->email);
        $this->assertSame('Professional Developer', $user->display_name);
        $this->assertSame('Professional', $user->first_name);
        $this->assertSame('Developer', $user->last_name);
        $this->assertSame('active', $user->status);
        $this->assertSame('freelancer', $user->role);
        $this->assertSame('https://example.com/avatar.jpg', $user->avatar);
        $this->assertSame(4.8, $user->rating);
        $this->assertSame(125, $user->reviews_count);
        $this->assertSame(98, $user->completed_projects);
        $this->assertSame('US', $user->country_code);
        $this->assertSame('America/New_York', $user->timezone);
        $this->assertSame(1577836800, $user->member_since);
    }

    /**
     * Test accessing fields in different ways.
     */
    #[Test]
    public function it_accessing_fields_in_different_ways(): void
    {
        $user = new User(['id' => 123, 'username' => 'test_user', 'email' => 'test@example.com']);

        // Via magic getter
        $this->assertSame(123, $user->id);
        $this->assertSame('test_user', $user->username);

        // Via toArray
        $array = $user->toArray();
        $this->assertSame(123, $array['id']);
        $this->assertSame('test_user', $array['username']);
        $this->assertSame('test@example.com', $array['email']);
    }

    /**
     * Test that User data is immutable from external modifications.
     */
    #[Test]
    public function it_user_data_immutable_from_external_modifications(): void
    {
        $originalData = ['id' => 123, 'username' => 'original'];
        $user         = new User($originalData);

        // Modify the original array
        $originalData['username']  = 'modified';
        $originalData['new_field'] = 'new_value';

        // User should still have original data
        $this->assertSame('original', $user->username);
        $this->assertNull($user->new_field);
    }

    /**
     * Test User with minimal required data.
     */
    #[Test]
    public function it_user_with_minimal_data(): void
    {
        $user = new User(['id' => 1]);

        $this->assertSame(1, $user->id);
        $this->assertNull($user->username);
        $this->assertNull($user->email);
    }

    /**
     * Test User with very large dataset.
     */
    #[Test]
    public function it_user_with_large_dataset(): void
    {
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data["field_$i"] = "value_$i";
        }

        $user = new User($data);

        for ($i = 0; $i < 100; $i++) {
            $this->assertSame("value_$i", $user->{"field_$i"});
        }

        $this->assertCount(100, $user->toArray());
    }
}
