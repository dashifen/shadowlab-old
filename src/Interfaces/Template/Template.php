<?php

namespace Shadowlab\Interfaces\Template;

use Shadowlab\Interfaces\Page\File;
use Shadowlab\Exceptions\TemplateException;

/**
 * Interface Template
 * @package Shadowlab\Interfaces\Template
 */
interface Template
{
    /**
     * @return File
     */
    public function getFile();

    /**
     * @param File $file
     * @return void
     */
    public function setFile(File $file);

    /**
     * @return string
     */
    public function getContents();

    /**
     * @param string $contents
     * @return void
     */
    public function setContents($contents);

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data);

    /**
     * @param $field
     * @param $value
     * @throws TemplateException
     * @return void
     */
    public function addData($field, $value);

    /**
     * @return void
     */
    public function resetData();

    /**
     * @throws TemplateException
     * @return string
     */
    public function apply();
}
