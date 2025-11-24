<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

use ArrayAccess;
use JsonSerializable;

/**
 * Thread model class
 * Represents a Thread object from the Freelancer API.
 */
class Thread implements ArrayAccess, JsonSerializable
{
    protected ?int $id             = null;
    protected ?array $thread       = null;
    protected ?array $context      = null;
    protected ?array $members      = null;
    protected ?int $owner          = null;
    protected ?string $thread_type = null;
    protected ?int $time_created   = null;
    protected array $attributes    = [];

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThread(): ?array
    {
        return $this->thread;
    }

    public function getContext(): ?array
    {
        return $this->context;
    }

    public function getMembers(): ?array
    {
        return $this->members;
    }

    public function getOwner(): ?int
    {
        return $this->owner;
    }

    public function getThreadType(): ?string
    {
        return $this->thread_type;
    }

    public function getTimeCreated(): ?int
    {
        return $this->time_created;
    }

    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

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

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    // ArrayAccess implementation for backward compatibility
    public function offsetExists($offset): bool
    {
        return property_exists($this, $offset) || isset($this->attributes[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (property_exists($this, $offset)) {
            $this->$offset = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        if (property_exists($this, $offset)) {
            $this->$offset = null;
        } else {
            unset($this->attributes[$offset]);
        }
    }

    // Magic getter for backward compatibility
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return $this->attributes[$name] ?? null;
    }

    // Magic setter for backward compatibility
    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            $this->attributes[$name] = $value;
        }
    }

    public function __isset(string $name): bool
    {
        return property_exists($this, $name) || isset($this->attributes[$name]);
    }
}
