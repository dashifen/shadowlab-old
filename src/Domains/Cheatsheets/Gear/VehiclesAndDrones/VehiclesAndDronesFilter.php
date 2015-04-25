<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\VehiclesAndDrones;

use Shadowlab\Exceptions\FilterException;
use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\AbstractFilter;
use Shadowlab\Interfaces\Domain\Domain;
use Shadowlab\Interfaces\Domain\Entity;

class VehiclesAndDronesFilter extends AbstractFilter
{
    /**
     * @var VehiclesAndDrones
     */
    protected $domain;

    /**
     * @param Entity $entity
     * @throws EntityException
     */
    public function setEntity(Entity $entity)
    {
        if (!($entity instanceof VehiclesAndDronesEntity)) {
            throw new EntityException("Unexpected Entity:  " . get_class($entity));
        }

        $this->entity = $entity;
    }

    /**
     * @param Domain $domain
     * @throws FilterException
     */
    protected function setDomain(Domain $domain)
    {
        if (!($domain instanceof VehiclesAndDrones)) {
            throw new FilterException("Unexpected Domain:  " . get_class($domain));
        }

        $this->domain = $domain;
    }

    public function filterInsert()
    {
        $properties = VehiclesAndDronesEntity::getProperties();


    }

    public function filterSelect()
    {
    }

    public function filterUpdate()
    {
    }

    public function filterDelete()
    {
    }
}