<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

/**
 * Bid model class
 * Represents a Bid object from the Freelancer API.
 */
class Bid extends BaseType
{
    protected ?int $id                   = null;
    protected ?int $project_id           = null;
    protected ?int $bidder_id            = null;
    protected ?float $amount             = null;
    protected ?int $period               = null;
    protected ?string $description       = null;
    protected ?int $milestone_percentage = null;
    protected ?bool $retracted           = null;
    protected ?int $time_submitted       = null;

    /**
     * Get the bid's identifier.
     *
     * @return int|null The bid identifier, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the project identifier for the bid.
     *
     * @return int|null The project ID, or `null` if not set.
     */
    public function getProjectId(): ?int
    {
        return $this->project_id;
    }

    /**
     * Gets the identifier of the bidder.
     *
     * @return int|null The bidder's user ID, or null if not set.
     */
    public function getBidderId(): ?int
    {
        return $this->bidder_id;
    }

    /**
     * Gets the bid amount.
     *
     * @return float|null The bid amount, or null if not set.
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /****
     * Gets the bid's delivery period in days.
     *
     * @return int|null The delivery period in days, or null if not set.
     */
    public function getPeriod(): ?int
    {
        return $this->period;
    }

    /**
     * Retrieve the bid description.
     *
     * @return string|null The bid description, or null if not set.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Retrieve the bid's milestone percentage.
     *
     * @return int|null The percentage of the bid allocated to milestones, or null if not set.
     */
    public function getMilestonePercentage(): ?int
    {
        return $this->milestone_percentage;
    }

    /**
     * Indicates whether the bid has been retracted.
     *
     * @return bool|null `true` if the bid is retracted, `false` if not retracted, `null` if the retraction status is unknown or not set.
     */
    public function isRetracted(): ?bool
    {
        return $this->retracted;
    }

    /**
     * Gets the time the bid was submitted.
     *
     * @return int|null The submission time as a Unix timestamp in seconds, or `null` if not set.
     */
    public function getTimeSubmitted(): ?int
    {
        return $this->time_submitted;
    }
}
