<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\MartialArtsTechniques;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\AbstractFilter;
use Shadowlab\Interfaces\Domain\Domain;use Shadowlab\Interfaces\Domain\Entity;

class MartialArtsTechniquesFilter extends AbstractFilter
{
    public function setEntity(Entity $entity)
    {
        if(!($entity instanceof MartialArtsTechniquesEntity)) {
            throw new EntityException("Unexpected Entity:  " . get_class($entity));
        }

        $this->entity = $entity;
    }

    public function filterSelect() { }
    public function filterInsert() { }
    public function filterUpdate() { }
    public function filterDelete() { } protected function setDomain(Domain $domain) { }
    public function validate(Entity $entity, Domain $domain, $action = "insert") { }
}