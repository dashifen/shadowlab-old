<?php

namespace Shadowlab\Interfaces;

/**
 * Interface SessionInterface
 * @package Shadowlab\Interfaces\Session
 */
interface Session
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

    /**
     * @param $index
     * @return mixed
     */
    public function get($index);

    /**
     * @param $index
     * @return bool
     */
    public function exists($index);

    /**
     * @param $index
     * @param $value
     * @return bool|mixed
     */
    public function set($index, $value);
}
