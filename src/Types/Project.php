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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSeoUrl(): ?string
    {
        return $this->seo_url;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getCurrency(): ?array
    {
        return $this->currency;
    }

    public function getBudget(): ?array
    {
        return $this->budget;
    }

    public function getJobs(): ?array
    {
        return $this->jobs;
    }

    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getTracks(): ?array
    {
        return $this->tracks;
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
