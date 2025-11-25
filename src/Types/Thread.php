<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

/**
 * Thread model class
 * Represents a Thread object from the Freelancer API.
 */
class Thread extends BaseType
{
    protected ?int $id             = null;
    protected ?array $thread       = null;
    protected ?array $context      = null;
    protected ?array $members      = null;
    protected ?int $owner          = null;
    protected ?string $thread_type = null;
    protected ?int $time_created   = null;

    /**
     * Gets the thread identifier.
     *
     * @return int|null The thread id if available, otherwise null.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retrieve the thread payload as an associative array.
     *
     * @return array|null The thread data array, or null if not set.
     */
    public function getThread(): ?array
    {
        return $this->thread;
    }

    /**
     * Retrieve the thread's context data.
     *
     * @return array|null The context data for the thread, or null if not set.
     */
    public function getContext(): ?array
    {
        return $this->context;
    }

    /**
     * Get the thread members.
     *
     * @return array|null An array of members, or null if not set.
     */
    public function getMembers(): ?array
    {
        return $this->members;
    }

    /**
     * Gets the ID of the thread owner.
     *
     * @return int|null The owner's user ID, or `null` if not set.
     */
    public function getOwner(): ?int
    {
        return $this->owner;
    }

    /**
     * The thread's type.
     *
     * @return string|null The thread type if set, `null` otherwise.
     */
    public function getThreadType(): ?string
    {
        return $this->thread_type;
    }

    /**
     * Gets the thread creation timestamp.
     *
     * @return int|null The Unix timestamp when the thread was created, or null if not set.
     */
    public function getTimeCreated(): ?int
    {
        return $this->time_created;
    }
}
