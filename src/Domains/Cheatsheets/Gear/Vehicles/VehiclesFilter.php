<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\Vehicles;

use Shadowlab\Domains\Cheatsheets\Gear\GearFilter;
use Shadowlab\Exceptions\FilterException;
use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Domain;
use Shadowlab\Interfaces\Domain\Entity;

class VehiclesFilter extends GearFilter
{
    /**
     * @var Vehicles
     */
    protected $domain;

    /**
     * @param Entity $entity
     * @throws EntityException
     */
    public function setEntity(Entity $entity)
    {
        if (!($entity instanceof VehiclesEntity)) {
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
        if (!($domain instanceof Vehicles)) {
            throw new FilterException("Unexpected Domain:  " . get_class($domain));
        }

        $this->domain = $domain;
    }

    public function filterInsert()
    {
        $this->errors = parent::filterInsert();

        // the parent filterInset() method will handle the $properties that all gear has (e.g. names, categories,
        // availabilities, etc.).  that leaves us to handle those here which only vehicles and drones need to care
        // about.  therefore, we don't use a foreach loop over all of our $properties.  instead, we focus in on
        // only the ones that matter to us here.

        $attributes = $this->entity->get("attributes");
        foreach ($attributes as $attribute_id => $rating) {
            if (empty($rating) && $rating != 0) {
                $this->errors["attribute_" . $attribute_id] = "Please enter a rating.";
            }
        }

        return $this->errors;
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