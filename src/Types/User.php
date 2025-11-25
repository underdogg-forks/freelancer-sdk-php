<?php

namespace FreelancerSdk\Types;

/**
 * User model class
 * Represents a User object from the Freelancer API.
 */
class User
{
    private array $data;

    /**
     * Create a User instance from raw user data.
     *
     * Stores the provided associative user data in the object's internal storage.
     *
     * @param array $userData Associative array of user fields as returned by the Freelancer API.
     */
    public function __construct(array $userData)
    {
        $this->data = $userData;
    }

    /**
     * Retrieve a value from the user's internal data by key.
     *
     * @param string $name The data key to retrieve.
     * @return mixed|null The value associated with `$name`, or `null` if the key does not exist.
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Get the user's internal data as an associative array.
     *
     * @return array The user's data keyed by field name.
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
