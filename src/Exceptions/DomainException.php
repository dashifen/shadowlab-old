<?php

namespace Shadowlab\Exceptions;

class DomainException extends \Exception
{
    public function __constrct($message, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
