<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Exceptions\Messages\MessageNotCreatedException;
use FreelancerSdk\Resources\Messages\Messages;
use FreelancerSdk\Session;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    private function sessionWithResponses(Response ...$responses): Session
    {
        $mock    = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        return new Session('token_123', 'https://fake-fln.com', ['handler' => $handler]);
    }

    #[Test]
    public function it_creates_a_project_thread(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'id' => 301,
                'thread' => [
                    'thread_type' => 'private_chat',
                    'time_created' => 1483228800,
                    'members' => [101, 102],
                    'context' => [
                        'id' => 201,
                        'type' => 'project',
                    ],
                    'owner' => 101,
                ],
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $messages = new Messages($session);
        $thread = $messages->createProjectThread([102], 201, "Let's talk");

        $this->assertSame(301, $thread->id);
        $this->assertSame('project', $thread->thread['context']['type']);
        $this->assertSame(201, $thread->thread['context']['id']);
    }

    #[Test]
    public function it_posts_a_message(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'id' => 401,
                'from_user_id' => 101,
                'thread_id' => 301,
                'message' => "Let's talk",
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $messages = new Messages($session);
        $message = $messages->postMessage(301, "Let's talk");

        $this->assertSame(401, $message->id);
        $this->assertSame(301, $message->thread_id);
        $this->assertSame("Let's talk", $message->message);
    }

    #[Test]
    public function it_posts_an_attachment(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'id' => 401,
                'from_user_id' => 101,
                'thread_id' => 301,
                'message' => '',
                'attachments' => [
                    [
                        'key' => 501,
                        'filename' => 'file.txt',
                        'message_id' => 401,
                    ],
                ],
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $messages = new Messages($session);
        $fileResource = fopen('php://memory', 'r');
        $message = $messages->postAttachment(301, [
            ['file' => $fileResource, 'filename' => 'file.txt'],
        ]);

        $this->assertSame(401, $message->id);
        $this->assertSame(301, $message->thread_id);
        $this->assertIsArray($message->attachments);
        $this->assertCount(1, $message->attachments);
    }

    #[Test]
    public function it_gets_messages(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'unfiltered_count' => 2,
                'messages' => [
                    [
                        'message_source' => 'default_msg',
                        'attachments' => [],
                        'thread_id' => 1,
                        'message' => 'Hello world!',
                        'id' => 1,
                    ],
                    [
                        'message_source' => 'default_msg',
                        'attachments' => [],
                        'thread_id' => 1,
                        'message' => 'Test message',
                        'id' => 2,
                    ],
                ],
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $messages = new Messages($session);
        $result = $messages->getMessages(['threads[]' => [1], 'thread_details' => true]);

        $this->assertIsArray($result);
        $this->assertCount(2, $result['messages']);
        $this->assertSame('Hello world!', $result['messages'][0]['message']);
    }

    #[Test]
    public function it_searches_messages(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'unfiltered_count' => 1,
                'messages' => [
                    [
                        'message_source' => 'default_msg',
                        'attachments' => [],
                        'thread_id' => 1,
                        'message' => 'Hello world!',
                        'id' => 1,
                    ],
                ],
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $messages = new Messages($session);
        $result = $messages->searchMessages(1, 'Hello world!', 20, 0);

        $this->assertIsArray($result);
        $this->assertCount(1, $result['messages']);
        $this->assertSame('Hello world!', $result['messages'][0]['message']);
    }

    #[Test]
    public function it_gets_threads(): void
    {
        $responseBody = json_encode([
            'status' => 'success',
            'result' => [
                'threads' => [
                    [
                        'time_updated' => 1519826182,
                        'thread' => [
                            'context' => [
                                'type' => 'project',
                                'id' => 101,
                            ],
                            'thread_type' => 'private_chat',
                            'write_privacy' => 'members',
                            'time_created' => 1519826180,
                            'id' => 100,
                            'members' => [102, 103],
                            'owner' => 103,
                            'owner_read_privacy' => 'members',
                            'read_privacy' => 'members',
                        ],
                        'is_muted' => false,
                        'is_read' => true,
                    ],
                ],
            ],
        ]);

        $session = $this->sessionWithResponses(
            new Response(200, ['Content-Type' => 'application/json'], $responseBody)
        );

        $messages = new Messages($session);
        $result = $messages->getThreads(['threads[]' => [1]]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result['threads']);
        $this->assertSame(100, $result['threads'][0]['thread']['id']);
    }

    #[Test]
    public function it_throws_exception_when_posting_attachment_fails(): void
    {
        $responseBody = json_encode([
            'status' => 'error',
            'message' => 'An error has occurred.',
            'error_code' => 'ExceptionCodes.UNKNOWN_ERROR',
            'request_id' => '3ab35843fb99cde325d819a4',
        ]);

        $session = $this->sessionWithResponses(
            new Response(500, ['Content-Type' => 'application/json'], $responseBody)
        );

        $messages = new Messages($session);
        $fileResource = fopen('php://memory', 'r');

        $this->expectException(MessageNotCreatedException::class);
        $this->expectExceptionMessage('An error has occurred.');

        $messages->postAttachment(301, [
            ['file' => $fileResource, 'filename' => 'file.txt'],
        ]);
    }
}
