<?php

namespace Shadowlab\Interfaces\Page;

/**
 * Interface File
 * @package Shadowlab\Interfaces\Page
 */
interface File
{
    /**
     * @return string
     */
    public function getFile();

    /**
     * @param $file
     * @return void
     */
    public function setFile($file);

    /**
     * @param null $file
     * @return string
     */
    public function getType($file = null);

    /**
     * @return string
     */
    public function getContents();
}