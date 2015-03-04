<?php

namespace Shadowlab\Session;

use Shadowlab\Interfaces\Session as SessionInterface;

/**
 * Class Session
 * @package Shadowlab\Session
 */
class Session implements SessionInterface
{
    /**
     *
     */
    public function __construct()
    {
        if(session_id()=="") session_start();
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->exists('AUTHENTICATED');
    }

    /**
     * Initializes a visitor's authenticated session.
     * @param string $username
     * @param null $role
     * @return void
     */
    public function login($username, $role = null)
    {
        session_regenerate_id();
        $_SESSION['AUTHENTICATED'] = true;
        $_SESSION['USERNAME'] = $username;
        $_SESSION['ROLE'] = $role;
    }

    /**
     * Completely destroys a visitor's session.
     * @return void
     */
    public function logout()
    {
        // when logging out, we want to explicitly and completely destroy this person's session.
        // according to the PHP manual, this is the best way to do that (see: http://goo.gl/nBVl0
        // for more information).

        $_SESSION = [];
        $p = session_get_cookie_params();
        setcookie(session_name(), "", time()-42000, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
        session_destroy();
    }

    /**
     * @param $index
     * @param $default
     * @return mixed
     */
    public function get($index, $default = null)
    {
        $retval = $this->exists($index) ? $_SESSION[$index] : $default;
        return $retval;
    }

    /**
     * @param $index
     * @return bool
     */
    public function exists($index)
    {
        return isset($_SESSION[$index]);
    }

    /**
     * @param $index
     * @param $value
     * @return mixed
     */
    public function set($index, $value)
    {
        return $_SESSION[$index] = $value;
    }

    /**
     * @param $index
     * @return void
     */
    public function remove($index)
    {
        unset($_SESSION[$index]);
    }
}
