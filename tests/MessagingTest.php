<?php
declare(strict_types=1);
namespace FreelancerSdk\Tests;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MessagingTest extends TestCase
{
    #[Test]
    public function it_sends_a_message_and_returns_array(): void
    {
        $messaging = $this->createMock(\FreelancerSdk\Resources\Messaging::class);
        $messaging->method('sendMessage')->willReturn(['id' => 1, 'body' => 'Hello', 'to' => 123]);
        $result = $messaging->sendMessage(['to' => 123, 'body' => 'Hello']);
        $this->assertIsArray($result);
        $this->assertSame(1, $result['id']);
        $this->assertSame('Hello', $result['body']);
        $this->assertSame(123, $result['to']);
    }
}
