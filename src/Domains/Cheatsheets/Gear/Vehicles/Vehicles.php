<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\Vehicles;

use Aura\View\Exception;
use Shadowlab\Interfaces\Domain\Filter;
use Shadowlab\Interfaces\Domain\Gateway;
use Shadowlab\Interfaces\Domain\Factory;
use Shadowlab\Exceptions\DomainException;
use Shadowlab\Interfaces\Domain\Payloads\PayloadFactory;
use Shadowlab\Domains\Cheatsheets\Gear\Gear;

class Vehicles extends Gear
{
    /**
     * @var VehiclesFilter
     */
    protected $filter;

    /**
     * @var VehiclesFactory
     */
    protected $factory;

    /**
     * @var VehiclesGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    public function getVehicles()
    {
        try {
            $vehicles = $this->gateway->select();

            return $vehicles !== false
                ? $this->payload->found(["vehicles" => $vehicles])
                : $this->payload->notFound(["vehicles" => ""]);

        } catch (\Exception $e) {
            return $this->payload->error(["exception" => $e]);
        }
    }

    public function getFormData()
    {
        return [
            "categories" => $this->getGearCategories(),
            "attributes" => $this->getGearAttributes(),
            "vehicle"    => $this->getMostRecentGear(),
            "books"      => $this->getBooks(),
        ];
    }

    public function getGearCategories()
    {
        /*
         * SELECT child.gear_category_id, parent.gear_category parent_category, child.gear_category
         * FROM gear_categories child
         * LEFT JOIN gear_categories parent ON parent.gear_category_id = child.parent_category_id
         * WHERE child.parent_category_id IS NOT NULL AND parent.gear_category_id IN (1, 10)
         * ORDER BY parent.gear_category, child.gear_category;
         */

        $parent_categories = $this->getGearParentCategories();

        return $this->gateway->getResults(
            ["child.gear_category_id", "parent.gear_category parent_category", "child.gear_category"],
            "gear_categories child LEFT JOIN gear_categories parent ON parent.gear_category_id = child.parent_category_id",
            ["child.parent_category_id" => ["IS NOT", "NULL"], "parent.gear_category_id" => ["IN", $parent_categories]],
            ["parent.gear_category", "child.gear_category"]
        );
    }

    public function getGearAttributes()
    {
        return $this->gateway->getMap(["attribute_id", "attribute"], "attributes", ["category" => "vehicle"], ["attribute_order"]);
    }

    public function getMostRecentGear()
    {
        $parent_categories = $this->getGearParentCategories();
        $gear_categories = $this->gateway->getCol("gear_category_id", "gear_categories", ["parent_category_id" => ["IN", $parent_categories]]);

        $vehicle = $this->gateway->getRow(
            ["gear", "abbr", "page"],
            "gear INNER JOIN books USING (book_id)",
            ["gear_category_id" => ["IN", $gear_categories]],
            ["gear_id DESC"]
        );

        return $vehicle != false
            ? $vehicle["gear"] . " (p. " . $vehicle["abbr"] . ", " . $vehicle["page"] . ")"
            : false;
    }

    protected function getGearParentCategories()
    {
        return $this->gateway->getCol("gear_category_id", "gear_categories", ["gear_category" => ["IN", ["Vehicles", "Drones"]]]);
    }

    /**
     * @param Filter $filter
     * @throws DomainException
     */
    protected function setFilter(Filter $filter)
    {
        if ($filter instanceof VehiclesFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof VehiclesFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof VehiclesGateway) $this->gateway = $gateway;
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
