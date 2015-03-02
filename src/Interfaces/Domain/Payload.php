<?php

namespace Shadowlab\Interfaces\Domain;

interface Payload
{
    public function getType();
    public function getPayload($key = null);
    public function setPayload(array $payload);
    public function resetPayload();
}
