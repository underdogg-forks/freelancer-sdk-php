<?php

namespace FreelancerSdk\Resources;

/**
 * Services resource class
 * Handles all service-related API operations.
 */
class Services
{
    /**
     * Retrieve a list of services, optionally filtered by criteria.
     *
     * @param array $filters Associative array of filter criteria (for example: 'category', 'query', 'page', 'per_page').
     * @return array List of services where each service is represented as an associative array of its attributes.
     */
    public function listServices(array $filters = []): array
    {
        // ...API call logic...
        return [];
    }
    // ...other service-related methods...
}
