<?php

namespace FreelancerSdk\Types;

/**
 * Project model class
 * Represents a Project object from the Freelancer API
 */
class Project
{
    private array $data;

    public function __construct(array $projectData)
    {
        $this->data = $projectData;
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