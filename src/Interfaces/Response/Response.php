<?php

namespace Shadowlab\Interfaces\Response;

use Shadowlab\Interfaces\Domain\Payload;

interface Response
{
    public function execute();
    public function setData(array $data = []);
    public function setView($view, array $data = []);
    public function setPayload(Payload $payload);

    public function handle404();
    public function unauthorized();
    public function redirect($url);

    public function send();
}