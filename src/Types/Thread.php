<?php

declare(strict_types=1);

namespace FreelancerSdk\Types;

class Thread
{
    public int $id;
    public array $thread;
    public ?array $context = null;
    public ?array $members = null;
    public ?int $owner = null;
    public ?string $thread_type = null;
    public ?int $time_created = null;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
