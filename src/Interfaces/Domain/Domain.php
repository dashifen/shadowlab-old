<?php

namespace Shadowlab\Interfaces\Domain;

interface Domain
{
    public function getPayload($type);
    public function getBooks();
}