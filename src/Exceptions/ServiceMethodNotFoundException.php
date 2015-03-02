<?php

namespace Shadowlab\Exceptions;

class ServiceMethodNotFoundException extends \Exception
{
    public function __constrct($service, $method, array $arguments, \Exception $previous = null)
    {
        $message  = "Method not found: ";
        $message .= $service . "::" . $method;
        $message .= "(" . join(", ", $arguments) . ")";
        parent::__construct($message, 0, $previous);
    }
}
