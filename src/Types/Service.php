<?php

namespace FreelancerSdk\Types;

/**
 * Service model class
 * Represents a Service object from the Freelancer API.
 */
class Service
{
    private array $data;

    /**
     * Create a Service instance from the provided service data.
     *
     * Stores the given associative array as the instance's internal data representation of a service.
     *
     * @param array $serviceData Associative array of service fields and values.
     */
    public function __construct(array $serviceData)
    {
        $this->data = $serviceData;
    }

    /**
     * Retrieve a field value from the service data by name.
     *
     * @param string $name The field name to retrieve from the internal data array.
     * @return mixed|null The field value if present, `null` otherwise.
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Get the service's internal data as an associative array.
     *
     * @return array The stored service data keyed by field names.
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
