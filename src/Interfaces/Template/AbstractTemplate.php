<?php

namespace Shadowlab\Interfaces\Template;

use Shadowlab\Exceptions\TemplateException;
use Shadowlab\Interfaces\Page\File;

abstract class AbstractTemplate implements Template
{
    /**
     * @var File
     */
    protected $file;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @param File $file
     */
    public function __construct(File $file) {
        $this->setContents($file->getContents());
        $this->setFile($file);
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     * @return void
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->content;
    }

    /**
     * @param string $contents
     * @return void
     */
    public function setContents($contents)
    {
        $this->content = $contents;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->getData();
    }

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param $field
     * @param $value
     * @throws TemplateException
     * @return void
     */
    public function addData($field, $value)
    {
        // adding a field/value pair to our data is very simple except that we want to help avoid problems
        // by throwing an exception if $field already exists in $this->data.  as a result, unless this method
        // is overridden by a child, the following pattern is necessary to replace data within a Template:
        //
        //      $data = $template->getData();
        //      $data = $template->resetData();
        //      $data['some_index'] = 'some_value';
        //      $template->setData($data);
        //
        // while complicated, it makes sure that it is a programmer's explicit need to replace data within
        // a Template rather than an accident.

        if(isset($this->data[$field])) throw new TemplateException('{$field} already exists in Template data.');
        $this->data[$field] = $value;
    }

    /**
     * @return void
     */
    public function resetData()
    {
        $this->data = [];
    }

    /**
     * @throws TemplateException
     * @return string
     */
    abstract public function apply();
}
