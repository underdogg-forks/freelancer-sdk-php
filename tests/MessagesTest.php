<?php

declare(strict_types=1);

namespace FreelancerSdk\Tests;

use FreelancerSdk\Exceptions\Messages\MessageNotCreatedException;
use FreelancerSdk\Resources\Messages\Messages;
use PHPUnit\Framework\Attributes\Test;

class MessagesTest extends BaseTestCase
{
    #[Test]
    public function it_creates_a_project_thread(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'id'     => 301,
                'thread' => [
                    'thread_type'  => 'private_chat',
                    'time_created' => 1483228800,
                    'members'      => [101, 102],
                    'context'      => ['id' => 201, 'type' => 'project'],
                    'owner'        => 101,
                ],
            ])
        );

        $messages = new Messages($session);
        $thread   = $messages->createProjectThread([102], 201, "Let's talk");

        $this->assertSame(301, $thread->id);
        $this->assertSame('project', $thread->thread['context']['type']);
        $this->assertSame(201, $thread->thread['context']['id']);
    }

    #[Test]
    public function it_posts_a_message(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'id'           => 401,
                'from_user_id' => 101,
                'thread_id'    => 301,
                'message'      => "Let's talk",
            ])
        );

        $messages = new Messages($session);
        $message  = $messages->postMessage(301, "Let's talk");

        $this->assertSame(401, $message->id);
        $this->assertSame(301, $message->thread_id);
        $this->assertSame("Let's talk", $message->message);
    }

    #[Test]
    public function it_posts_an_attachment(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'id'           => 401,
                'from_user_id' => 101,
                'thread_id'    => 301,
                'message'      => '',
                'attachments'  => [
                    ['key' => 501, 'filename' => 'file.txt', 'message_id' => 401],
                ],
            ])
        );

        $messages     = new Messages($session);
        $fileResource = fopen('php://memory', 'r');
        $message      = $messages->postAttachment(301, [
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
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'unfiltered_count' => 2,
                'messages'         => [
                    ['id' => 1, 'thread_id' => 1, 'message' => 'Hello world!'],
                    ['id' => 2, 'thread_id' => 1, 'message' => 'Test message'],
                ],
            ])
        );

        $messages = new Messages($session);
        $result   = $messages->getMessages(['threads[]' => [1]]);

        $this->assertIsArray($result);
        $this->assertCount(2, $result['messages']);
        $this->assertSame('Hello world!', $result['messages'][0]['message']);
    }

    #[Test]
    public function it_searches_messages(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'unfiltered_count' => 1,
                'messages'         => [
                    ['id' => 1, 'thread_id' => 1, 'message' => 'Hello world!'],
                ],
            ])
        );

        $messages = new Messages($session);
        $result   = $messages->searchMessages(1, 'Hello world!', 20, 0);

        $this->assertIsArray($result);
        $this->assertCount(1, $result['messages']);
        $this->assertSame('Hello world!', $result['messages'][0]['message']);
    }

    #[Test]
    public function it_gets_threads(): void
    {
        $session = $this->createMockSession(
            $this->createSuccessResponse([
                'threads' => [
                    [
                        'time_updated' => 1519826182,
                        'thread'       => [
                            'id'          => 100,
                            'context'     => ['type' => 'project', 'id' => 101],
                            'thread_type' => 'private_chat',
                            'members'     => [102, 103],
                            'owner'       => 103,
                        ],
                        'is_muted' => false,
                        'is_read'  => true,
                    ],
                ],
            ])
        );

        $messages = new Messages($session);
        $result   = $messages->getThreads(['threads[]' => [1]]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result['threads']);
        $this->assertSame(100, $result['threads'][0]['thread']['id']);
    }

    #[Test]
    public function it_throws_exception_when_posting_attachment_fails(): void
    {
        $session      = $this->createMockSession($this->createErrorResponse());
        $messages     = new Messages($session);
        $fileResource = fopen('php://memory', 'r');

        $this->expectException(MessageNotCreatedException::class);
        $this->expectExceptionMessage('An error has occurred.');

        $messages->postAttachment(301, [
            ['file' => $fileResource, 'filename' => 'file.txt'],
        ]);
    }
}
