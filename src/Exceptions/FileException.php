<?php

namespace Shadowlab\Exceptions;

class FileException extends \Exception
{
    /**
     * @var string
     */
    protected $file;

    public function __construct($message, $file='', \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->setTheFile($file);
    }

    /**
     * @return string
     */
    public function getTheFile()
    {
        return $this->file;
    }

    /**
     * @param string
     */
    public function setTheFile($file)
    {
        $this->file = $file;
    }


}