<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

use ArrayAccess;
use JsonSerializable;

/**
 * Message model class
 * Represents a Message object from the Freelancer API.
 */
class Message implements ArrayAccess, JsonSerializable
{
    protected ?int $id            = null;
    protected ?int $thread_id     = null;
    protected ?int $from_user_id  = null;
    protected ?string $message    = null;
    protected ?int $time_created  = null;
    protected ?array $attachments = null;
    protected array $attributes   = [];

    /**
     * Create a Message and populate its properties from the given data array.
     *
     * The provided associative array's keys that match class properties are assigned to those
     * properties; unknown keys are stored in the internal attributes bag.
     *
     * @param array $data Associative array of initial values for properties and attributes.
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * Populate the message from an associative array, mapping known keys to class properties and unknown keys into the attributes bag.
     *
     * @param array $data Associative array of values to set; keys matching class properties are assigned directly, other keys are stored in `attributes`.
     * @return self The current instance (fluent interface).
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

    /****
     * Get the message ID.
     *
     * @return int|null The message's ID, or null if not set.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the thread identifier for this message.
     *
     * @return int|null The thread ID if set, otherwise null.
     */
    public function getThreadId(): ?int
    {
        return $this->thread_id;
    }

    /**
     * Gets the sender user ID of the message.
     *
     * @return int|null The ID of the user who sent the message, or null if not set.
     */
    public function getFromUserId(): ?int
    {
        return $this->from_user_id;
    }

    /**
     * Gets the message text.
     *
     * @return string|null The message text, or `null` if not set.
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Gets the Unix timestamp when the message was created.
     *
     * @return int|null The Unix timestamp of creation, or null if not set.
     */
    public function getTimeCreated(): ?int
    {
        return $this->time_created;
    }

    /**
     * Retrieve attachments associated with the message.
     *
     * @return array|null The attachments for the message, or `null` if none are set.
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    /**
     * Retrieve an attribute value from the attributes bag.
     *
     * If the attribute key does not exist, the provided default is returned.
     *
     * @param string $key The attribute name.
     * @param mixed $default Value to return when the attribute is not set.
     * @return mixed The attribute value if present, `$default` otherwise.
     */
    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Convert the Message object into an associative array combining declared properties and dynamic attributes.
     *
     * Properties with null values are omitted; entries from the `attributes` bag are merged into the top-level array.
     *
     * @return array The message represented as an associative array with attributes flattened into top-level keys.
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
     * Provide the data used when the message is serialized to JSON.
     *
     * Returns an associative array representation of the message with primary properties merged with any extra attributes; primary properties with `null` values are omitted.
     *
     * @return array Associative array suitable for JSON encoding representing the message.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Determine if a given property name or attribute key exists on the Message.
     *
     * @param mixed $offset The property name or attribute key to check.
     * @return bool `true` if the named public property exists or the attributes array contains the key, `false` otherwise.
     */
    public function offsetExists($offset): bool
    {
        return property_exists($this, $offset) || isset($this->attributes[$offset]);
    }

    /**
     * Retrieve a property or attribute value by key.
     *
     * @param string|int $offset The property name or attribute key to retrieve.
     * @return mixed The value of the public property or the attributes entry for the given key, or `null` if neither exists.
     */
    public function offsetGet($offset): mixed
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
        return $this->attributes[$offset] ?? null;
    }

    /**
     * Assigns a value to a named field on the message or stores it in the attributes bag.
     *
     * If a public property with the given name exists on the object, that property is set; otherwise the value
     * is saved in the internal attributes array under the given key.
     *
     * @param string|int|null $offset The name of the property or attribute key.
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
     * Removes the value at the given offset from the message object.
     *
     * If the offset corresponds to a declared property, that property is set to null;
     * otherwise the offset is removed from the attributes bag.
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
     * Access a named property or stored attribute for backward compatibility.
     *
     * Retrieves the public property value when the property exists on this object;
     * otherwise returns the value from the internal attributes bag or `null` if not present.
     *
     * @param string $name The property or attribute name to retrieve.
     * @return mixed The property value if present, the attribute value if present, or `null`.
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return $this->attributes[$name] ?? null;
    }

    /**
     * Sets a field value on the object or stores it in the attributes bag for unknown keys.
     *
     * If the named property exists on the instance, assigns the value to that property; otherwise saves the value under `$attributes[$name]`.
     *
     * @param string $name  The property or attribute name to set.
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
     * Determines whether the given property name exists as a declared property or an attribute on the message.
     *
     * @param string $name The property or attribute name to check.
     * @return bool `true` if the property exists or the attribute is set, `false` otherwise.
     */
    public function __isset(string $name): bool
    {
        return property_exists($this, $name) || isset($this->attributes[$name]);
    }
}