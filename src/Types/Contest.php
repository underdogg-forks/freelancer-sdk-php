<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

/**
 * Contest model class
 * Represents a Contest object from the Freelancer API.
 */
class Contest extends BaseType
{
    protected ?int $id             = null;
    protected ?int $owner_id       = null;
    protected ?string $title       = null;
    protected ?string $description = null;
    protected ?string $type        = null;
    protected ?int $duration       = null;
    protected ?array $jobs         = null;
    protected ?array $currency     = null;
    protected ?float $prize        = null;

    /**
     * Initialize the Contest model and populate its properties from provided data.
     *
     * @param array $data Associative array of initial values; keys that match class properties
     *                    will be assigned to those properties, and any other keys will be stored
     *                    in the `attributes` array.
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * Populate the model from an associative array, assigning known keys to class properties and storing unknown keys in `attributes`.
     *
     * @param array $data Associative array of values; keys that match existing properties are set on the instance, other keys are saved into the `attributes` array.
     * @return self The current instance with values applied.
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
     * Get the contest identifier.
     *
     * @return int|null The contest identifier, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the contest owner's identifier.
     *
     * @return int|null The owner's identifier, or null if not set.
     */
    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    /**
     * Gets the contest title.
     *
     * @return string|null The contest title, or null if not set.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Retrieve the contest description.
     *
     * @return string|null The contest description, or null if not set.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Retrieve the contest type.
     *
     * @return string|null The contest type, or null if not set.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Gets the contest duration.
     *
     * @return int|null The contest duration, or null if not set.
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * Returns the contest's list of jobs.
     *
     * @return array|null The jobs associated with the contest, or `null` if not set.
     */
    public function getJobs(): ?array
    {
        return $this->jobs;
    }

    /**
     * Gets the contest's currency information.
     *
     * @return array|null The currency information as an associative array, or `null` if not set.
     */
    public function getCurrency(): ?array
    {
        return $this->currency;
    }

    /**
     * Gets the contest prize amount.
     *
     * @return float|null The prize amount, or `null` if not set.
     */
    public function getPrize(): ?float
    {
        return $this->prize;
    }
}