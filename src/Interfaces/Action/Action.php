<?php

namespace Shadowlab\Interfaces\Action;

/**
 * Interface ActionInterface
 * @package Shadowlab\Interfaces
 */
interface Action
{
    /**
     * @return \Aura\Web\Response
     */
    public function execute();
}