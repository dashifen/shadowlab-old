<?php

namespace Shadowlab\Session;

/**
 * Class AbstractSession
 * @package Shadowlab\Interfaces\Session
 */
abstract class AbstractSession implements SessionInterface
{
    public function __construct()
    {
        if(session_id()=="") session_start();
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return isset($_SESSION['AUTHENTICATED']);
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
     * @param string $function
     * @param array $arguments
     * @return mixed
     */
    abstract public function __call($function, array $arguments = []);
}