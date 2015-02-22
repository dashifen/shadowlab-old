<?php

namespace Shadowlab\Pages\Files;

use Shadowlab\Exceptions\FileException;

class CSS extends File
{
    public function setFile($file)
    {
        $type = strtolower($this->getType($file));
        if($type != 'css') throw new FileException("Invalid CSS type: {$type}", $file);
        parent::setFile($file);
    }
}
