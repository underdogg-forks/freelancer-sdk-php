<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

/**
 * Thread model class
 * Represents a Thread object from the Freelancer API.
 */
class Thread extends BaseType
{
    protected ?int $id             = null;
    protected ?array $thread       = null;
    protected ?array $context      = null;
    protected ?array $members      = null;
    protected ?int $owner          = null;
    protected ?string $thread_type = null;
    protected ?int $time_created   = null;

    /**
     * Gets the thread identifier.
     *
     * @return int|null The thread id if available, otherwise null.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retrieve the thread payload as an associative array.
     *
     * @return array|null The thread data array, or null if not set.
     */
    public function getThread(): ?array
    {
        return $this->thread;
    }

    /**
     * Retrieve the thread's context data.
     *
     * @return array|null The context data for the thread, or null if not set.
     */
    public function getContext(): ?array
    {
        return $this->context;
    }

    /**
     * Get the thread members.
     *
     * @return array|null An array of members, or null if not set.
     */
    public function getMembers(): ?array
    {
        return $this->members;
    }

    /**
     * Gets the ID of the thread owner.
     *
     * @return int|null The owner's user ID, or `null` if not set.
     */
    public function getOwner(): ?int
    {
        return $this->owner;
    }

    /**
     * The thread's type.
     *
     * @return string|null The thread type if set, `null` otherwise.
     */
    public function getThreadType(): ?string
    {
        return $this->thread_type;
    }

    /**
     * Gets the thread creation timestamp.
     *
     * @return int|null The Unix timestamp when the thread was created, or null if not set.
     */
    public function getTimeCreated(): ?int
    {
        return $this->time_created;
    }

    /**
     * Retrieve a dynamic attribute by key.
     *
     * @param string $key The attribute name to retrieve.
     * @param mixed $default Value to return if the attribute is not set.
     * @return mixed The attribute value if present, `$default` otherwise.
     */
    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Convert the Thread object into an associative array.
     *
     * Includes declared properties with non-null values; entries from the `attributes`
     * array are merged into the resulting array at the top level.
     *
     * @return array Associative array representing the thread: declared properties (excluding nulls) keyed by property name, with `attributes` merged into top-level keys.
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
     * Produce a JSON-serializable array representation of the Thread.
     *
     * @return array An array containing the Thread's non-null properties with dynamic attributes merged into the top-level array.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Check if a declared property or dynamic attribute exists for the given offset.
     *
     * @param mixed $offset The property name or attribute key to check.
     * @return bool `true` if a declared property with that name exists or an attribute with that key is set, `false` otherwise.
     */
    public function offsetExists($offset): bool
    {
        return property_exists($this, $offset) || isset($this->attributes[$offset]);
    }

    /**
     * Fetches a declared property or a dynamic attribute by offset, preferring class properties when present.
     *
     * @param string|int $offset The property name or attribute key to retrieve.
     * @return mixed The value of the declared property or attribute, or `null` if not set.
     */
    public function offsetGet($offset): mixed
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
        return $this->attributes[$offset] ?? null;
    }

    /**
     * Sets a value on a declared property or stores it as a dynamic attribute.
     *
     * @param string|int|null $offset The property name or attribute key to set.
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
     * Unsets the given offset on the object.
     *
     * If the offset matches a declared property, that property is set to `null`; otherwise the key is removed from the dynamic `attributes` array.
     *
     * @param string|int $offset The property name or attribute key to unset.
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
     * Access a declared property or a dynamic attribute by name.
     *
     * @param string $name The property or attribute name.
     * @return mixed The value of the declared property if it exists; otherwise the dynamic attribute value, or `null` if not set.
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return $this->attributes[$name] ?? null;
    }

    /**
     * Sets a declared property or stores the value as a dynamic attribute for backward compatibility.
     *
     * If a property with the given name exists on the object, assigns the value to that property;
     * otherwise stores the value in the internal `attributes` array under the given name.
     *
     * @param string $name  The property or attribute name.
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
     * Determine whether a declared property or a dynamic attribute with the given name is present.
     *
     * @param string $name The property or attribute name to check.
     * @return bool `true` if a class property with that name exists or an attribute with that name is set, `false` otherwise.
     */
    public function __isset(string $name): bool
    {
        return property_exists($this, $name) || isset($this->attributes[$name]);
    }
}