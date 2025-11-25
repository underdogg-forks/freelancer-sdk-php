<?php

namespace FreelancerSdk\Types;

/**
 * Milestone model class
 * Represents a Milestone object from the Freelancer API.
 */
class Milestone
{
    private array $data;

    /**
     * Initialize the Milestone with raw milestone data.
     *
     * @param array $milestoneData Associative array of milestone properties as returned by the Freelancer API.
     */
    public function __construct(array $milestoneData)
    {
        $this->data = $milestoneData;
    }

    /**
     * Retrieve a milestone field value by name.
     *
     * @param string $name The field name to retrieve.
     * @return mixed|null The value of the field if set, or `null` if not present.
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Sets a named field on the underlying milestone data array, creating or updating the entry.
     *
     * @param string $name The field name to set.
     * @param mixed $value The value to assign to the field.
     * @return void
     */
    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Check whether a given milestone property is set in the underlying data.
     *
     * @param string $name The property name to check.
     * @return bool `true` if the property exists and is set, `false` otherwise.
     */
    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Convert the Milestone object to an associative array.
     *
     * @return array The underlying milestone data keyed by field names.
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
