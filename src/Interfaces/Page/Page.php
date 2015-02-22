<?php

namespace Shadowlab\Interfaces\Page;

interface Page
{
    public function addStyle(...$styles);
    public function addScript(...$scripts);
}
