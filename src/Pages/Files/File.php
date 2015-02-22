<?php

namespace Shadowlab\Pages\Files;

use Shadowlab\Exceptions\FileException;

class File implements \Shadowlab\Interfaces\Page\File
{
    protected $file;

    public function __construct($file)
    {
        $this->setFile($file);
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     * @throws FileException
     */
    public function setFile($file)
    {
        if (!is_file($file)) throw new FileException("File not found", $file);
        $this->file = $file;
    }

    public function getType($file = null)
    {
        if($file === null) $file = $this->file;
        $file_parts = explode(".", $file);
        $extension = array_pop($file_parts);
        return strtolower($extension);
    }

    public function getContents()
    {
        return file_get_contents($this->file);
    }
}
