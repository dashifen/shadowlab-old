<?php

namespace Shadowlab\Session;

/**
 * Interface SessionInterface
 * @package Shadowlab\Interfaces\Session
 */
interface SessionInterface
{
    /**
     * @return bool
     */
    public function isAuthenticated();

    /**
     * @param string $username
     * @param string $role
     * @return mixed
     */
    public function login($username, $role = null);

    /**
     * @return void
     */
    public function logout();
}