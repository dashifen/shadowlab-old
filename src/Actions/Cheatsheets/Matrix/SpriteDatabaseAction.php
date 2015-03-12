<?php

namespace Shadowlab\Actions\Cheatsheets\Matrix;

use Shadowlab\Interfaces\Action\AbstractAction;

class SpriteDatabaseAction extends AbstractAction
{
    /**
     * @var \Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase\SpriteDatabase
     */
    protected $domain;

    /**
     * @var \Shadowlab\Responses\Cheatsheets\Matrix\SpriteDatabase
     */
    protected $http;

    public function execute()
    {
        $forms = $this->domain->getSprites();
        $this->http->setPayload($forms);
        return $this->http->execute();
    }
}