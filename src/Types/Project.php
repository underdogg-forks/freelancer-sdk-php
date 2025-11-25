<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

use ArrayAccess;
use JsonSerializable;

/**
 * Project model class
 * Represents a Project object from the Freelancer API.
 */
class Project implements ArrayAccess, JsonSerializable
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
    protected array $attributes    = [];

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

    /**
     * Retrieve a dynamic attribute value by key.
     *
     * @param string $key The attribute key to look up.
     * @param mixed $default Value to return if the attribute is not set.
     * @return mixed The attribute value if present, otherwise the provided `$default`.
     */
    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Convert the project to an associative array, merging dynamic attributes into top-level keys.
     *
     * Builds an array containing all non-null defined properties and merges entries from the internal
     * attributes map into the result so dynamic fields appear as top-level keys.
     *
     * @return array The assembled associative array representation of the project.
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
     * Provide an associative array representation of the project suitable for JSON serialization.
     *
     * @return array The project's data as an associative array ready for JSON encoding.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Determine whether a property or attribute with the given name exists on the model.
     *
     * @param mixed $offset The property name or attribute key to check.
     * @return bool `true` if a defined class property exists or the attribute key is set, `false` otherwise.
     */
    public function offsetExists($offset): bool
    {
        return property_exists($this, $offset) || isset($this->attributes[$offset]);
    }

    /**
     * Retrieve a value by property name or attribute key for ArrayAccess-style access.
     *
     * @param string|int $offset The property name or attribute key to retrieve.
     * @return mixed The value of the named property or attribute, or null if not present.
     */
    public function offsetGet($offset): mixed
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
        return $this->attributes[$offset] ?? null;
    }

    /**
     * Set a value for the given offset on the project model, assigning to a declared property when present or storing it in the attributes map otherwise.
     *
     * @param mixed $offset The property name or attribute key.
     * @param mixed $value The value to assign.
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
     * Remove the value identified by the given offset from the project.
     *
     * If the offset corresponds to a declared class property, that property is set to null;
     * otherwise the key is removed from the internal attributes map.
     *
     * @param mixed $offset The property name or attribute key to unset.
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
     * Retrieve a property value by name, supporting declared class properties and dynamic attributes.
     *
     * @param string $name The property name to retrieve.
     * @return mixed The property value if present, otherwise `null`.
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return $this->attributes[$name] ?? null;
    }

    /**
     * Sets a declared property or stores a value in the dynamic attributes map for backward compatibility.
     *
     * If the class has a declared property with the given name, the value is assigned to that property;
     * otherwise the value is stored in the `$attributes` array under the provided name.
     *
     * @param string $name The property name to set.
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
     * Determine whether a named property or dynamic attribute is present.
     *
     * Checks if the class defines the property with the given name or if the
     * dynamic attribute with that key exists and is set.
     *
     * @param string $name The property or attribute name to check.
     * @return bool `true` if the property is defined on the object or the attribute with that key is set, `false` otherwise.
     */
    public function __isset(string $name): bool
    {
        return property_exists($this, $name) || isset($this->attributes[$name]);
    }
}