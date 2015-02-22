<?php

namespace Shadowlab\Pages\Files;

use Shadowlab\Exceptions\FileException;
use Shadowlab\Interfaces\Page\AbstractFile;

class Javascript extends File
{
    public function setFile($file)
    {
        $type = strtolower($this->getType($file));
        if($type != 'js') throw new FileException("Invalid Javascript type: {$type}", $file);
        parent::setFile($file);
    }
}
