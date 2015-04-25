<?php

namespace Shadowlab\Actions\Cheatsheets\Magic;

use Shadowlab\Interfaces\Action\AbstractAction;

class Enchantments extends AbstractAction
{
    public function execute()
    {
        $spells = $this->domain->getEnchantments();
        $this->http->setPayload($spells);
        return $this->http->execute();
    }
}
