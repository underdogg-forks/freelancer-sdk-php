<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

class Contest
{
    public int $id;
    public int $owner_id;
    public string $title;
    public string $description;
    public string $type;
    public int $duration;
    public array $jobs;
    public array $currency;
    public float $prize;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
