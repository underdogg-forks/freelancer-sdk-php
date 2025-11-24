<?php
namespace FreelancerSdk\Types;
/**
 * User model class
 * Represents a User object from the Freelancer API
 */
class User
{
    private array $data;
    public function __construct(array $userData)
    {
        $this->data = $userData;
    }
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }
    public function toArray(): array
    {
        return $this->data;
    }
}

