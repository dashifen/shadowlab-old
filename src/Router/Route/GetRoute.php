<?php

namespace Shadowlab\Router\Route;

class GetRoute extends AbstractRoute
{
	public function matchRoute($path, $type)
    {
		return $type == "GET" && $this->path == $path;
	}
}
