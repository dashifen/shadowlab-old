<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\VehiclesAndDrones;

use Aura\View\Exception;
use Shadowlab\Exceptions\DatabaseException;
use Shadowlab\Interfaces\Domain\Filter;
use Shadowlab\Interfaces\Domain\Gateway;
use Shadowlab\Interfaces\Domain\Factory;
use Shadowlab\Exceptions\DomainException;
use Shadowlab\Interfaces\Domain\Payloads\PayloadFactory;
use Shadowlab\Interfaces\Domain\AbstractDomain;

/**
 * Class User
 * @package Shadowlab\Domains\User
 */
class VehiclesAndDrones extends AbstractDomain
{
    /**
     * @var VehiclesAndDronesFilter
     */
    protected $filter;

    /**
     * @var VehiclesAndDronesFactory
     */
    protected $factory;

    /**
     * @var VehiclesAndDronesGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    public function getVehiclesAndDrones()
    {
        try {
            $vehicles_and_drones = $this->gateway->select();
            return $vehicles_and_drones !== false
                ? $this->payload->found([ 'vehicles_and_drones' => $vehicles_and_drones ])
                : $this->payload->notFound([ 'vehicles_and_drones' => '' ]);
        } catch (\Exception $e) {
            return $this->payload->error([ 'exception' => $e ]);
        }
    }

    /**
     * @param array $post
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function addRitual(array $post)
    {
        $ritual = $this->factory->newEntity($post);
        $valid  = $this->filter->validate($ritual, $this, "insert");

        // if $valid is not true, then we can simply return a notValid payload along with the
        // errors that our filter identified.  we also pass back the posted values which we could
        // grab in our action, but it's just as easy to send them as a part of the payload here.

        if (!$valid) {
            return $this->payload->notValid([
                "errors" => $this->filter->getErrors(),
                "values" => $ritual->getAll(),
            ]);
        }

        // if we didn't return, then we need to try and insert our $ritual into the database.  we can
        // pass the entity over to the gateway object and it'll take over from there.  then, based on
        // whether or not we were successful in our insertion, we'll send back a created or notCreated
        // payload.

        try {
            $success = $this->gateway->insert($ritual);
        } catch (DatabaseException $e) {
            return $this->payload->error([
                "values"    => $ritual->getAll(),
                "exception" => $e
            ]);
        }

        return !$success
            ? $this->payload->notCreated(["errors"=>$this->filter->getErrors(), "values"=>$ritual->getAll()])
            : $this->payload->created(["ritual_id"=>$success, "values"=>$ritual->getAll()]);
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        return [
            "schools"        => $this->getSchools(),
            "metamagics"     => $this->getMetamagics(),
            "ritual"         => $this->getMostRecentRitual(),
            "vehicles_and_drones"        => $this->getPriorVehiclesAndDrones(),
            "ritual_lengths" => $this->getRitualLengths(),
            "ritual_tags"    => $this->getRitualTags(),
            "books"          => $this->getBooks(),
        ];
    }

    /**
     * @return bool|string
     */
    public function getMostRecentRitual()
    {
        $ritual = $this->gateway->getRow(
            ["ritual","abbr","page"],
            "vehicles_and_drones INNER JOIN books USING (book_id)", [],
            ["ritual_id DESC"]
        );

        return $ritual != false
            ? $ritual["ritual"] . " (p. " . $ritual["page"] . ", " . $ritual["abbr"] . ")"
            : false;
    }

    /**
     * @return bool|array
     */
    public function getPriorVehiclesAndDrones()
    {
        return $this->gateway->getMap(["ritual_id", "ritual"], "vehicles_and_drones", [], ["ritual"]);
    }

    /**
     * @return bool|array
     */
    public function getSchools()
    {
        return $this->gateway->getMap(["school_id", "school_name"], "metamagics_schools", [], ["school_name"]);
    }

    /**
     * @return bool|array
     */
    public function getMetamagics()
    {
        return $this->gateway->getMap(["metamagic_id", "metamagic"], "metamagics", [], ["metamagic"]);
    }

    /**
     * @return bool|array
     */
    public function getRitualLengths()
    {
        return $this->gateway->getEnumValues("vehicles_and_drones", "length");
    }

    /**
     * @return bool|array
     */
    public function getRitualTags()
    {
        return $this->gateway->getMap(["ritual_tag_id", "ritual_tag"], "vehicles_and_drones_ritual_tags", [], ["ritual_tag"]);
    }

    /**
     * @param Filter $filter
     * @throws DomainException
     */
    protected function setFilter(Filter $filter)
    {
        if ($filter instanceof VehiclesAndDronesFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof VehiclesAndDronesFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof VehiclesAndDronesGateway) $this->gateway = $gateway;
        else throw new DomainException("Unexpected gateway: " . get_class($gateway));
    }

    /**
     * @param PayloadFactory $payload
     */
    protected function setPayload(PayloadFactory $payload)
    {
        $this->payload = $payload;
    }
}
