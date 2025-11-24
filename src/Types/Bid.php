<?php

namespace FreelancerSdk\Types;

/**
 * Bid model class
 * Represents a Bid object from the Freelancer API.
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
