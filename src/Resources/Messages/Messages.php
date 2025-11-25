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

    /**
     * Initialize the Messages resource with a session used for HTTP requests.
     */
    public function __construct(
        private readonly Session $session
    ) {
    }

    /**
     * Creates a message thread with the specified members, context, and initial message.
     *
     * @param int[] $memberIds Array of user IDs to include in the thread.
     * @param string $contextType The context type for the thread (for example, 'project').
     * @param int $context Numeric identifier for the context (for example, a project ID).
     * @param string $message Initial message body to post in the thread.
     * @return Thread The created Thread instance.
     * @throws ThreadNotCreatedException If the thread could not be created.
     */
    public function createThread(array $memberIds, string $contextType, int $context, string $message): Thread
    {
        try {
            $response = $this->session->getClient()->post(
                self::ENDPOINT . '/threads/',
                [
                    'headers'     => ['Content-Type' => 'application/x-www-form-urlencoded'],
                    'form_params' => [
                        'members[]'    => $memberIds,
                        'context_type' => $contextType,
                        'context'      => $context,
                        'message'      => $message,
                    ],
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 200 && isset($data['result'])) {
                return new Thread($data['result']);
            }

            throw new ThreadNotCreatedException(
                $data['message']    ?? 'Failed to create thread',
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
     * Create a thread scoped to a specific project with the given members and initial message.
     *
     * @param int[] $memberIds Array of member user IDs to include in the thread.
     * @param int $projectId The project ID to associate the thread with.
     * @param string $message The initial message content for the thread.
     * @return Thread The created thread.
     * @throws ThreadNotCreatedException If the thread could not be created.
     */
    public function createProjectThread(array $memberIds, int $projectId, string $message): Thread
    {
        return $this->createThread($memberIds, 'project', $projectId, $message);
    }

    / **
     * Posts a message to an existing thread.
     *
     * @param int $threadId The ID of the thread to post the message to.
     * @param string $message The message body to post.
     * @return Message A Message representing the created message.
     * @throws MessageNotCreatedException If the API response does not contain a result or if the HTTP request fails.
     */
    public function postMessage(int $threadId, string $message): Message
    {
        try {
            $response = $this->session->getClient()->post(
                self::ENDPOINT . '/threads/' . $threadId . '/messages/',
                [
                    'headers'     => ['Content-Type' => 'application/x-www-form-urlencoded'],
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
                $data['message']    ?? 'Failed to post message',
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
     * Uploads attachments to a thread and returns the created Message.
     *
     * @param int $threadId The ID of the thread to post attachments to.
     * @param array<array{file: resource, filename: string}> $attachments List of attachments; each item must contain a `file` stream resource and a `filename`.
     * @return Message The Message object created by the API.
     * @throws MessageNotCreatedException If the API responds with an error or the upload fails.
     */
    public function postAttachment(int $threadId, array $attachments): Message
    {
        try {
            $files     = [];
            $filenames = [];

            foreach ($attachments as $attachment) {
                $files[] = [
                    'name'     => 'files[]',
                    'contents' => $attachment['file'],
                    'filename' => $attachment['filename'],
                ];
                $filenames[] = $attachment['filename'];
            }

            $multipart = array_merge(
                [
                    [
                        'name'     => 'attachments[]',
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
                $data['message']    ?? 'Failed to post attachment',
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
     * Retrieve messages that match the given query parameters with pagination.
     *
     * @param array<string,mixed> $query Associative query parameters used to filter results; `limit` and `offset` will be set by this method.
     * @param int $limit Maximum number of messages to return.
     * @param int $offset Number of messages to skip (zero-based).
     * @return array<string,mixed> Array of message records returned by the API (the `result` payload).
     * @throws MessagesNotFoundException If the API returns a non-200 response or the request fails.
     */
    public function getMessages(array $query, int $limit = 10, int $offset = 0): array
    {
        try {
            $query['limit']  = $limit;
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
                $data['message']    ?? 'Messages not found',
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
         * Search messages within a thread using optional context and window filters.
         *
         * @param int $threadId The ID of the thread to search.
         * @param string $query The search query string.
         * @param int $limit Maximum number of results to return.
         * @param int $offset Number of results to skip.
         * @param bool|null $contextDetails When true, include message context details in results.
         * @param int|null $windowAbove Number of messages above a match to include when contextDetails is enabled.
         * @param int|null $windowBelow Number of messages below a match to include when contextDetails is enabled.
         * @return array<string, mixed> The API search results array.
         * @throws MessagesNotFoundException If the search fails or no results are returned.
         */
    public function searchMessages(
        int $threadId,
        string $query,
        int $limit = 20,
        int $offset = 0,
        ?bool $contextDetails = null,
        ?int $windowAbove = null,
        ?int $windowBelow = null
    ): array {
        try {
            $queryParams = [
                'thread_id' => $threadId,
                'query'     => $query,
                'limit'     => $limit,
                'offset'    => $offset,
            ];

            if ($contextDetails !== null) {
                $queryParams['message_context_details'] = $contextDetails;
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
                $data['message']    ?? 'Messages not found',
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
     * Retrieve message threads matching the provided query parameters.
     *
     * @param array<string,mixed> $query Query parameters to filter or paginate threads.
     * @return array<string,mixed> The API `result` payload containing matching threads.
     * @throws ThreadsNotFoundException Thrown when the API does not return threads or the request fails.
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
                $data['message']    ?? 'Threads not found',
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