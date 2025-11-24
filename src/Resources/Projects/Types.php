<?php

namespace FreelancerSdk\Resources\Projects;

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

/**
 * Bid model class
 * Represents a Bid object from the Freelancer API
 */
class Bid
{
    private array $data;

    public function __construct(array $bidData)
    {
        $this->data = $bidData;
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

/**
 * Project type enumeration
 */
enum ProjectType: int
{
    case FIXED = 0;
    case HOURLY = 1;
}

/**
 * Milestone reason enumeration
 */
enum MilestoneReason: int
{
    case FULL_PAYMENT = 0;
    case PARTIAL_PAYMENT = 1;
    case TASK_DESCRIPTION = 2;
    case OTHER = 3;
}
