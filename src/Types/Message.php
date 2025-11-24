<?php
namespace FreelancerSdk\Types;
/**
 * Message model class
 * Represents a Message object from the Freelancer API
 */
class Message
{
    private array $data;
    public function __construct(array $messageData)
    {
        $this->data = $messageData;
    }
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }
    public function toArray(): array
    {
        return $this->data;
    }
}

