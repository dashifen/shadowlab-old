<?php

namespace Shadowlab\Interfaces\Page;

/**
 * Interface Partial
 * @package Shadowlab\Interfaces\Page
 */
interface Partial
{
    /**
     * @return File
     */
    public function getFile();

    /**
     * @param File $file
     * @return bool
     */
    public function setFile(File $file);

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     * @param bool $reset
     * @return bool
     */
    public function setData(array $data = [], $reset = false);

    /**
     * @return string
     */
    public function getContent();
}