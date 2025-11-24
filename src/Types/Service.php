<?php

namespace FreelancerSdk\Types;

/**
 * Service model class
 * Represents a Service object from the Freelancer API.
 */
class Service
{
    private array $data;

    public function __construct(array $serviceData)
    {
        $this->data = $serviceData;
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
