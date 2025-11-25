<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

/**
 * Project model class
 * Represents a Project object from the Freelancer API.
 */
class Project extends BaseType
{
    protected ?int $id             = null;
    protected ?string $title       = null;
    protected ?string $description = null;
    protected ?string $seo_url     = null;
    protected ?string $url         = null;
    protected ?array $currency     = null;
    protected ?array $budget       = null;
    protected ?array $jobs         = null;
    protected ?int $owner_id       = null;
    protected ?string $status      = null;
    protected ?array $tracks       = null;

    /**
     * Create a Project instance populated from provided data.
     *
     * Initializes declared properties from the provided associative array; any keys
     * that do not match declared properties are stored in the instance's attributes map.
     *
     * @param array $data Associative array of project fields (e.g. id, title, description, url, currency, budget).
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * Populate the model from an associative array.
     *
     * Keys in `$data` that match declared class properties are assigned to those properties;
     * any other key/value pairs are stored in the internal `$attributes` map.
     *
     * @param array $data Associative array of field names to values.
     * @return self The current instance (allows method chaining).
     */
    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            } else {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    /**
     * Get the project's identifier.
     *
     * @return int|null The project id, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retrieve the project's title.
     *
     * @return string|null The project title, or null if not set.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Retrieve the project's description.
     *
     * @return string|null The project's description, or null if not set.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Provides the project's SEO-friendly URL slug.
     *
     * @return string|null The SEO-friendly URL slug, or null if not set.
     */
    public function getSeoUrl(): ?string
    {
        return $this->seo_url;
    }

    /**
     * Get the project's public URL.
     *
     * @return string|null The project's URL if set, otherwise null.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Set the project's URL.
     *
     * @param string $url The project's URL.
     * @return self The current instance.
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Gets the project's currency information.
     *
     * @return array|null The currency details for the project, or null if not set.
     */
    public function getCurrency(): ?array
    {
        return $this->currency;
    }

    /**
     * Gets the project's budget details.
     *
     * @return array|null The project's budget details as an associative array, or `null` if not available.
     */
    public function getBudget(): ?array
    {
        return $this->budget;
    }

    /**
     * Gets the project's jobs.
     *
     * @return array|null The project's jobs array, or null if not set.
     */
    public function getJobs(): ?array
    {
        return $this->jobs;
    }

    /**
     * Retrieve the project owner's user id.
     *
     * @return int|null The owner's user id if available, null otherwise.
     */
    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    /**
     * Gets the project's status.
     *
     * @return string|null The project status (for example, "open" or "closed"), or `null` if not set.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Retrieve the project's tracking information.
     *
     * @return array|null The project's tracks as an array, or null if not set.
     */
    public function getTracks(): ?array
    {
        return $this->tracks;
    }
}
