<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

/**
 * Message model class
 * Represents a Message object from the Freelancer API.
 */
class Message extends BaseType
{
    protected ?int $id            = null;
    protected ?int $thread_id     = null;
    protected ?int $from_user_id  = null;
    protected ?string $message    = null;
    protected ?int $time_created  = null;
    protected ?array $attachments = null;

    /****
     * Get the message ID.
     *
     * @return int|null The message's ID, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the thread identifier for this message.
     *
     * @return int|null The thread ID if set, otherwise null.
     */
    public function getThreadId(): ?int
    {
        return $this->thread_id;
    }

    /**
     * Gets the sender user ID of the message.
     *
     * @return int|null The ID of the user who sent the message, or null if not set.
     */
    public function getFromUserId(): ?int
    {
        return $this->from_user_id;
    }

    /**
     * Gets the message text.
     *
     * @return string|null The message text, or `null` if not set.
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Gets the Unix timestamp when the message was created.
     *
     * @return int|null The Unix timestamp of creation, or null if not set.
     */
    public function getTimeCreated(): ?int
    {
        return $this->time_created;
    }

    /**
     * Retrieve attachments associated with the message.
     *
     * @return array|null The attachments for the message, or `null` if none are set.
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }
}
