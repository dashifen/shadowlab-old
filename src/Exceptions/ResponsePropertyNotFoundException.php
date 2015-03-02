<?php

namespace Shadowlab\Exceptions;

use Shadowlab\Interfaces\Response\Response;

class ResponsePropertyNotFoundException extends \Exception
{
    public function __construct(Response $response, $property, \Exception $previous = null)
    {
        $message = "Unexpected property, " . $property . ", in " . get_class($response);
        parent::__construct($message, 0, $previous);
    }
}
