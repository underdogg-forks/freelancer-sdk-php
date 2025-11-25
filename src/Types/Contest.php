<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

use ArrayAccess;
use JsonSerializable;

/**
 * Contest model class
 * Represents a Contest object from the Freelancer API.
 */
class Contest implements ArrayAccess, JsonSerializable
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
    protected array $attributes    = [];

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

    /**
     * Retrieve an additional attribute by key, returning a default when the key is not present.
     *
     * @param string $key The attribute key to retrieve.
     * @param mixed $default The value to return if the attribute key does not exist.
     * @return mixed The attribute value if present, `$default` otherwise.
     */
    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Produce an associative array representation of the contest, merging extra attributes into top-level keys.
     *
     * Properties whose value is `null` are omitted; entries from the `attributes` array are merged into the result.
     *
     * @return array Associative array of property names to values, with `attributes` entries merged into top-level keys.
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
     * Provide the contest's data as an associative array for JSON encoding.
     *
     * @return array Associative array containing the contest's properties and any additional attributes.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Checks whether a given offset corresponds to an existing class property or a stored attribute.
     *
     * @param mixed $offset The property name or attribute key to check.
     * @return bool `true` if the property exists on the object or the key is present in `attributes`, `false` otherwise.
     */
    public function offsetExists($offset): bool
    {
        return property_exists($this, $offset) || isset($this->attributes[$offset]);
    }

    /**
     * Retrieve a value by offset from the model, preferring declared properties over extra attributes.
     *
     * @param mixed $offset The property name or attribute key to retrieve.
     * @return mixed The value of the named property or attribute, or `null` if not present.
     */
    public function offsetGet($offset): mixed
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
        return $this->attributes[$offset] ?? null;
    }

    /**
     * Store a value for the given offset on the model.
     *
     * Assigns the value to a declared property when an identically named property exists; otherwise stores the value in the model's `attributes` array under the given offset.
     *
     * @param int|string|null $offset The key or property name to set.
     * @param mixed           $value  The value to assign.
     */
    public function offsetSet($offset, $value): void
    {
        if (property_exists($this, $offset)) {
            $this->$offset = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    /**
     * Unsets a value by key from the model, clearing declared properties or removing dynamic attributes.
     *
     * @param string|int $offset The property name or attribute key to remove.
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
     * Retrieve a property or attribute value by name for backward compatibility.
     *
     * If a declared class property with the given name exists, its value is returned;
     * otherwise the method returns the value stored in the dynamic `attributes` array
     * or `null` when the key is not present.
     *
     * @param string $name The property or attribute name to retrieve.
     * @return mixed The value of the property or attribute, or `null` if not found.
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return $this->attributes[$name] ?? null;
    }

    /**
     * Assigns a value to an existing property or stores it in the attributes array if the property does not exist.
     *
     * @param string $name The property name or attribute key.
     * @param mixed $value The value to assign.
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
     * Check whether a named property or dynamic attribute is present on the model.
     *
     * @param string $name The property or attribute name to check.
     * @return bool `true` if a defined property with that name exists or an attribute with that name is set, `false` otherwise.
     */
    public function __isset(string $name): bool
    {
        return property_exists($this, $name) || isset($this->attributes[$name]);
    }
}