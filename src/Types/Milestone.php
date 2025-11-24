<?php

namespace FreelancerSdk\Types;

/**
 * Milestone model class
 * Represents a Milestone object from the Freelancer API
 */
class Milestone
{
    private array $data;

    public function __construct(array $milestoneData)
    {
        $this->data = $milestoneData;
    }

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}