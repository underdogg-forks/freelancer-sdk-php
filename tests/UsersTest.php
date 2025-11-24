<?php
declare(strict_types=1);
namespace FreelancerSdk\Tests;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    #[Test]
    public function it_returns_a_user_profile_array(): void
    {
        $users = $this->createMock(\FreelancerSdk\Resources\Users::class);
        $users->method('getUserProfile')->willReturn(['id' => 123, 'name' => 'Test User']);
        $result = $users->getUserProfile(123);
        $this->assertIsArray($result);
        $this->assertSame(123, $result['id']);
        $this->assertSame('Test User', $result['name']);
    }
}
