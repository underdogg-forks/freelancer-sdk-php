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

    public function getProjectId(): ?int
    {
        return $this->project_id;
    }

    public function getBidderId(): ?int
    {
        return $this->bidder_id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getPeriod(): ?int
    {
        return $this->period;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getMilestonePercentage(): ?int
    {
        return $this->milestone_percentage;
    }

    public function isRetracted(): ?bool
    {
        return $this->retracted;
    }

    public function getTimeSubmitted(): ?int
    {
        return $this->time_submitted;
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
