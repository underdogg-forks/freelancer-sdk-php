<?php
declare(strict_types=1);
namespace FreelancerSdk\Tests;
use FreelancerSdk\Resources\Services;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ServicesTest extends TestCase
{
    #[Test]
    public function it_lists_services_and_returns_array(): void
    {
        $services = $this->createMock(Services::class);
        $services->method('listServices')->willReturn([
            ['id' => 1, 'name' => 'Service One'],
            ['id' => 2, 'name' => 'Service Two']
        ]);
        $result = $services->listServices();
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertSame('Service One', $result[0]['name']);
        $this->assertSame('Service Two', $result[1]['name']);
    }
}
