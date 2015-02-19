<?php

namespace Shadowlab\Session;

use Shadowlab\Exceptions\SessionException;

/**
 * Class Session
 * @package Shadowlab\Session
 */
class Session extends AbstractSession
{
    /**
     * @param string $function
     * @param array $arguments
     * @throws SessionException
     * @return mixed
     */
    public function __call($function, array $arguments = [])
    {
        // this method is called whenever an attempt to call a different but inaccessible, including non-existent,
        // method is made.  the only things that we want to handle here, though, are methods that begin with either
        // set* or get* so we're going to chunk up the $function argument, which is the method someone tried to
        // use, and see if it matches.

        $action = substr($function, 0, 3);
        if($action != "get" && $action != "set") throw new SessionException("Invalid session action: {$action}");

        $index  = strtoupper(substr($function, 3));
        $retval = $action == "set"
            ? $this->set($index, $arguments)
            : $this->get($index);

        return $retval;
    }

    protected function get($index)
    {
        $retval = null;
        if(!isset($_SESSION[$index])) trigger_error("Undefined index: {$index}");
        else $retval = $_SESSION[$index];
        return $retval;
    }

    protected function set($index, $value)
    {
        return $_SESSION[$index] = $value;
    }
}
