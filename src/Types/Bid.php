<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

use ArrayAccess;
use JsonSerializable;

/**
 * Bid model class
 * Represents a Bid object from the Freelancer API.
 */
class Bid implements ArrayAccess, JsonSerializable
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
    protected array $attributes          = [];

    /**
     * Create a Bid instance and populate its declared properties and attributes from the provided data array.
     *
     * @param array $data Associative array of initial values. Keys that match declared properties are assigned to those properties; other keys are stored in the object's attributes bag.
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * Populate the Bid object with values from the provided associative array.
     *
     * Keys that match declared properties are assigned to those properties; all other keys are stored in the internal `attributes` bag. Existing values are overwritten.
     *
     * @param array<string,mixed> $data Associative array of values to apply to the object.
     * @return $this The current Bid instance.
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

    / **
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

    /**
     * Retrieve a custom attribute from the attributes bag by key.
     *
     * @param string $key The attribute name to retrieve.
     * @param mixed $default Value to return when the attribute is not present.
     * @return mixed The attribute value if present, otherwise the provided default.
     */
    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Convert the bid to an associative array suitable for serialization.
     *
     * Only declared properties with non-null values are included. Any entries in
     * the `attributes` bag are merged into the returned array at the top level,
     * potentially overriding declared properties with the same keys.
     *
     * @return array<string,mixed> Associative array of bid data keyed by property or attribute name.
     */
    public function toArray(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $key => $value) {
            if ($key === 'attributes') {
                $data = array_merge($data, $value);
            } elseif ($value !== null) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * Convert the bid into an array representation for JSON serialization.
     *
     * The returned array includes all declared non-null properties and merges any dynamic attributes.
     *
     * @return array The array representation of the bid suitable for JSON encoding.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Checks whether the given offset exists as a declared property or as an attribute.
     *
     * @param mixed $offset The property name or attribute key to check.
     * @return bool `true` if a declared property with that name exists or an attribute with a non-null value is present, `false` otherwise.
     */
    public function offsetExists($offset): bool
    {
        return property_exists($this, $offset) || isset($this->attributes[$offset]);
    }

    /**
     * Retrieve a value by offset from the object's declared properties or its attributes bag.
     *
     * @param mixed $offset The property name or attribute key to retrieve.
     * @return mixed The value of the declared property or the attribute with the given key, or `null` if not present.
     */
    public function offsetGet($offset): mixed
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
        return $this->attributes[$offset] ?? null;
    }

    /**
     * Set a value by key on the Bid object; if the key matches a declared property it assigns that property, otherwise stores the value in the attributes bag.
     *
     * @param string|int|null $offset The property name or attribute key.
     * @param mixed $value The value to set.
     */
    public function offsetSet($offset, $value): void
    {
        if (property_exists($this, $offset)) {
            $this->$offset = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    / **
     * Unset the value identified by the given offset on the Bid object.
     *
     * If the offset corresponds to a declared property, that property is set to null;
     * otherwise the key is removed from the attributes bag.
     *
     * @param mixed $offset The property or attribute name to remove.
     */
    public function offsetUnset($offset): void
    {
        if (property_exists($this, $offset)) {
            $this->$offset = null;
        } else {
            unset($this->attributes[$offset]);
        }
    }

    /**
     * Retrieve a declared property or an attribute value by name for backward compatibility.
     *
     * @param string $name The name of the property or attribute to access.
     * @return mixed The declared property value if it exists; otherwise the attribute value, or `null` if not present.
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return $this->attributes[$name] ?? null;
    }

    /****
     * Set a property value on the object or store it in the attributes bag.
     *
     * If a declared property with the given name exists, assigns the value to that property;
     * otherwise stores the value in the internal attributes array to preserve dynamic fields.
     * Supports backward-compatible dynamic property assignment.
     *
     * @param string $name  The property name to set.
     * @param mixed  $value The value to assign.
     */
    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            $this->attributes[$name] = $value;
        }
    }

    /**
     * Checks whether a declared property exists on the object or an attribute with the given name is set.
     *
     * @param string $name The property or attribute name to check.
     * @return bool `true` if a declared property exists or an attribute with the name exists, `false` otherwise.
     */
    public function __isset(string $name): bool
    {
        return property_exists($this, $name) || isset($this->attributes[$name]);
    }
}