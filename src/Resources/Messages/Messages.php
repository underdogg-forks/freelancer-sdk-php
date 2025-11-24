<?php

declare(strict_types=1);

namespace FreelancerSdk\Resources\Messages;

use FreelancerSdk\Exceptions\Messages\MessageNotCreatedException;
use FreelancerSdk\Exceptions\Messages\MessagesNotFoundException;
use FreelancerSdk\Exceptions\Messages\ThreadNotCreatedException;
use FreelancerSdk\Exceptions\Messages\ThreadsNotFoundException;
use FreelancerSdk\Session;
use FreelancerSdk\Types\Message;
use FreelancerSdk\Types\Thread;
use GuzzleHttp\Exception\GuzzleException;

class Messages
{
    private const ENDPOINT = 'api/messages/0.1';

    public function __construct(
        private readonly Session $session
    ) {
    }

    /**
     * Create a thread
     *
     * @param  array<int>  $memberIds
     * @param  string  $contextType
     * @param  int  $context
     * @param  string  $message
     * @return Thread
     * @throws ThreadNotCreatedException
     * @throws GuzzleException
     */
    public function createThread(array $memberIds, string $contextType, int $context, string $message): Thread
    {
        try {
            $response = $this->session->getClient()->post(
                self::ENDPOINT . '/threads/',
                [
                    'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                    'form_params' => [
                        'members[]' => $memberIds,
                        'context_type' => $contextType,
                        'context' => $context,
                        'message' => $message,
                    ],
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['result'])) {
                return new Thread($data['result']);
            }

            throw new ThreadNotCreatedException(
                $data['message'] ?? 'Failed to create thread',
                $data['error_code'] ?? null,
                $data['request_id'] ?? null
            );
        } catch (GuzzleException $e) {
            throw new ThreadNotCreatedException(
                'Failed to create thread: ' . $e->getMessage(),
                null,
                null
            );
        }
    }

    /**
     * Create a project thread
     *
     * @param  array<int>  $memberIds
     * @param  int  $projectId
     * @param  string  $message
     * @return Thread
     * @throws ThreadNotCreatedException
     * @throws GuzzleException
     */
    public function createProjectThread(array $memberIds, int $projectId, string $message): Thread
    {
        return $this->createThread($memberIds, 'project', $projectId, $message);
    }

    /**
     * Post a message to a thread
     *
     * @param  int  $threadId
     * @param  string  $message
     * @return Message
     * @throws MessageNotCreatedException
     * @throws GuzzleException
     */
    public function postMessage(int $threadId, string $message): Message
    {
        try {
            $response = $this->session->getClient()->post(
                self::ENDPOINT . '/threads/' . $threadId . '/messages/',
                [
                    'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                    'form_params' => [
                        'message' => $message,
                    ],
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['result'])) {
                return new Message($data['result']);
            }

            throw new MessageNotCreatedException(
                $data['message'] ?? 'Failed to post message',
                $data['error_code'] ?? null,
                $data['request_id'] ?? null
            );
        } catch (GuzzleException $e) {
            throw new MessageNotCreatedException(
                'Failed to post message: ' . $e->getMessage(),
                null,
                null
            );
        }
    }

    /**
     * Post an attachment to a thread
     *
     * @param  int  $threadId
     * @param  array<array{file: resource, filename: string}>  $attachments
     * @return Message
     * @throws MessageNotCreatedException
     * @throws GuzzleException
     */
    public function postAttachment(int $threadId, array $attachments): Message
    {
        try {
            $files = [];
            $filenames = [];

            foreach ($attachments as $attachment) {
                $files[] = [
                    'name' => 'files[]',
                    'contents' => $attachment['file'],
                    'filename' => $attachment['filename'],
                ];
                $filenames[] = $attachment['filename'];
            }

            $multipart = array_merge(
                [
                    [
                        'name' => 'attachments[]',
                        'contents' => implode(',', $filenames),
                    ],
                ],
                $files
            );

            $response = $this->session->getClient()->post(
                self::ENDPOINT . '/threads/' . $threadId . '/messages/',
                [
                    'multipart' => $multipart,
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['result'])) {
                return new Message($data['result']);
            }

            throw new MessageNotCreatedException(
                $data['message'] ?? 'Failed to post attachment',
                $data['error_code'] ?? null,
                $data['request_id'] ?? null
            );
        } catch (GuzzleException $e) {
            throw new MessageNotCreatedException(
                'Failed to post attachment: ' . $e->getMessage(),
                null,
                null
            );
        }
    }

    /**
     * Get messages
     *
     * @param  array<string, mixed>  $query
     * @param  int  $limit
     * @param  int  $offset
     * @return array<string, mixed>
     * @throws MessagesNotFoundException
     * @throws GuzzleException
     */
    public function getMessages(array $query, int $limit = 10, int $offset = 0): array
    {
        try {
            $query['limit'] = $limit;
            $query['offset'] = $offset;

            $response = $this->session->getClient()->get(
                self::ENDPOINT . '/messages/',
                ['query' => $query]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['result'])) {
                return $data['result'];
            }

            throw new MessagesNotFoundException(
                $data['message'] ?? 'Messages not found',
                $data['error_code'] ?? null,
                $data['request_id'] ?? null
            );
        } catch (GuzzleException $e) {
            throw new MessagesNotFoundException(
                'Failed to get messages: ' . $e->getMessage(),
                null,
                null
            );
        }
    }

    /**
     * Search messages
     *
     * @param  int  $threadId
     * @param  string  $query
     * @param  int  $limit
     * @param  int  $offset
     * @param  bool|null  $messageContextDetails
     * @param  int|null  $windowAbove
     * @param  int|null  $windowBelow
     * @return array<string, mixed>
     * @throws MessagesNotFoundException
     * @throws GuzzleException
     */
    public function searchMessages(
        int $threadId,
        string $query,
        int $limit = 20,
        int $offset = 0,
        ?bool $messageContextDetails = null,
        ?int $windowAbove = null,
        ?int $windowBelow = null
    ): array {
        try {
            $queryParams = [
                'thread_id' => $threadId,
                'query' => $query,
                'limit' => $limit,
                'offset' => $offset,
            ];

            if ($messageContextDetails !== null) {
                $queryParams['message_context_details'] = $messageContextDetails;
            }
            if ($windowAbove !== null) {
                $queryParams['window_above'] = $windowAbove;
            }
            if ($windowBelow !== null) {
                $queryParams['window_below'] = $windowBelow;
            }

            $response = $this->session->getClient()->get(
                self::ENDPOINT . '/messages/search/',
                ['query' => $queryParams]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['result'])) {
                return $data['result'];
            }

            throw new MessagesNotFoundException(
                $data['message'] ?? 'Messages not found',
                $data['error_code'] ?? null,
                $data['request_id'] ?? null
            );
        } catch (GuzzleException $e) {
            throw new MessagesNotFoundException(
                'Failed to search messages: ' . $e->getMessage(),
                null,
                null
            );
        }
    }

    /**
     * Get threads
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     * @throws ThreadsNotFoundException
     * @throws GuzzleException
     */
    public function getThreads(array $query): array
    {
        try {
            $response = $this->session->getClient()->get(
                self::ENDPOINT . '/threads/',
                ['query' => $query]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['result'])) {
                return $data['result'];
            }

            throw new ThreadsNotFoundException(
                $data['message'] ?? 'Threads not found',
                $data['error_code'] ?? null,
                $data['request_id'] ?? null
            );
        } catch (GuzzleException $e) {
            throw new ThreadsNotFoundException(
                'Failed to get threads: ' . $e->getMessage(),
                null,
                null
            );
        }
    }
}
