<?php

namespace FreelancerSdk\Types;

/**
 * MilestoneRequest model class
 * Represents a Milestone Request object from the Freelancer API
 */
class MilestoneRequest
{
    private array $data;

    public function __construct(array $milestoneRequestData)
    {
        $this->data = $milestoneRequestData;
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