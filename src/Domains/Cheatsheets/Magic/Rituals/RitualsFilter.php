<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Rituals;

use Shadowlab\Exceptions\FilterException;
use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\AbstractFilter;
use Shadowlab\Interfaces\Domain\Domain;
use Shadowlab\Interfaces\Domain\Entity;

class RitualsFilter extends AbstractFilter
{
    /**
     * @var Rituals
     */
    protected $domain;

    /**
     * @param Entity $entity
     * @throws EntityException
     */
    public function setEntity(Entity $entity)
    {
        if (!($entity instanceof RitualsEntity)) {
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
        if (!($domain instanceof Rituals)) {
            throw new FilterException("Unexpected Domain:  " . get_class($domain));
        }

        $this->domain = $domain;
    }

    public function filterInsert()
    {
        $properties = RitualsEntity::getProperties();

        foreach ($properties as $property) {
            $value = $this->entity->get($property);

            switch ($property) {
                case "ritual":
                    if (empty($value)) {
                        $this->errors[$property] = "Please enter a name.";
                    }

                    break;

                case "description":
                    if (empty($value)) {
                        $this->errors[$property] = "Please enter a description.";
                    }

                    break;

                case "prerequisite_metamagic_id":
                    if (is_numeric($value) && array_search($value, array_keys($this->domain->getMetamagics())) === false) {
                        $this->errors[$property] = "Invalid metamagic ID.";
                    }

                    break;

                case "prerequisite_metamagic_school_id":
                    if (is_numeric($value) && array_search($value, array_keys($this->domain->getSchools())) === false) {
                        $this->errors[$property] = "Invalid school ID.";
                    }

                    break;

                case "prerequisite_ritual_id":
                    if (is_numeric($value) && array_search($value, array_keys($this->domain->getPriorRituals())) === false) {
                        $this->errors[$property] = "Invalid ritual ID.";
                    }

                    break;

                case "ritual_tags":
                    if (sizeof($value) > 0) {
                        $tags = array_keys($this->domain->getRitualTags());
                        $diff = array_diff($value, $tags);
                        if (sizeof($diff)) {
                            $this->errors[$property] = "Invalid tags in array.";
                        }
                    }

                    break;

                case "length":
                    if (empty($value)) {
                        $this->errors[$property] = "Please select a length.";
                    }

                    if (!empty($value) && array_search($value, $this->domain->getRitualLengths()) === false) {
                        $this->errors[$property] = "Unexpected length: $value.";
                    }

                    break;

                case "book_id":
                    if (empty($value)) {
                        $this->errors[$property] = "Please select a book.";
                    }

                    if (!empty($value) && array_search($value, array_keys($this->domain->getBooks())) === false) {
                        $this->errors[$property] = "Unexpected book: $value.";
                    }

                    break;

                case "page":
                    if (empty($value) || !is_numeric($value)) {
                        $this->errors[$property] = "Please enter a page.";
                    }

                    break;
            }
        }
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