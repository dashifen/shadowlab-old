<?php

namespace Shadowlab\Interfaces\Domain;

abstract class AbstractPayload implements Payload
{
    protected $payload = [];

    public function __construct(array $payload = null)
    {
        $this->setPayload($payload);
    }

    public function getType()
    {
        // $class includes the namespace.  but, for payloads, the namespace is always the same, so
        // it won't help us differentiate between them.  so we'll get a reflection of the class and
        // return its short name as follows.

        $reflection = new \ReflectionClass($this);
        return $reflection->getShortName();
    }

    public function getPayload($key = null)
    {
        if ($key === null) {
           return $this->payload;
        }

        if (isset($this->payload[$key])) {
            return $this->payload[$key];
        }

        return null;
    }

    public function setPayload(array $payload)
    {
        $this->payload = $payload;
    }

    public function resetPayload() {
        $this->payload = [];
    }
}
