<?php

namespace FreelancerSdk\Types;

/**
 * MilestoneRequest model class
 * Represents a Milestone Request object from the Freelancer API.
 */
class MilestoneRequest
{
    private array $data;

    /****
     * Initialize the MilestoneRequest with its underlying data array.
     *
     * @param array $milestoneRequestData Associative array of milestone request fields keyed by field name.
     */
    public function __construct(array $milestoneRequestData)
    {
        $this->data = $milestoneRequestData;
    }

    /**
     * Retrieve a value from the internal milestone data by key.
     *
     * @param string $name The data key to retrieve.
     * @return mixed|null The value associated with `$name`, or `null` if the key does not exist.
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Assigns a value to the specified field in the underlying data store.
     *
     * @param string $name The field name to set.
     * @param mixed $value The value to assign to the field.
     */
    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Determine whether a given key exists in the milestone request data.
     *
     * @param string $name The data key to check.
     * @return bool `true` if the key exists in the underlying data array, `false` otherwise.
     */
    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Retrieve the milestone request data as an associative array.
     *
     * @return array An associative array of milestone request fields and their values.
     */
    public function toArray(): array
    {
        return $this->data;
    }
}