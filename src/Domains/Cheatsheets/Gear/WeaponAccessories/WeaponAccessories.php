<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\WeaponAccessories;

use Aura\View\Exception;
use Shadowlab\Interfaces\Domain\Filter;
use Shadowlab\Interfaces\Domain\Gateway;
use Shadowlab\Interfaces\Domain\Factory;
use Shadowlab\Exceptions\DomainException;
use Shadowlab\Interfaces\Domain\Payloads\PayloadFactory;
use Shadowlab\Domains\Cheatsheets\Gear\Gear;

class WeaponAccessories extends Gear
{
    /**
     * @var WeaponAccessoriesFilter
     */
    protected $filter;

    /**
     * @var WeaponAccessoriesFactory
     */
    protected $factory;

    /**
     * @var WeaponAccessoriesGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    public function getWeaponAccessories()
    {
        try {
            $accessories = $this->gateway->select();

            return $accessories !== false
                ? $this->payload->found(["accessories" => $accessories])
                : $this->payload->notFound(["accessories" => ""]);

        } catch (\Exception $e) {
            return $this->payload->error(["exception" => $e]);
        }
    }

    public function getFormData()
    {
        return [
            "categories" => $this->getGearCategories(),
            "attributes" => $this->getGearAttributes(),
            "accessory"  => $this->getMostRecentGear(),
            "mounts"     => $this->getMounts(),
            "books"      => $this->getBooks(),
        ];
    }

    public function getMounts()
    {
        return $this->gateway->getMap(["mount_id", "mount"], "gear_mounts", [], ["mount"]);
    }

    public function getGearCategories()
    {
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
        return $this->gateway->getMap(
            ["attribute_id", "attribute"], "attributes",
            ["OR", ["category" => "weapon accessory"], ["category" => ["IS", "NULL"]]],
            ["attribute"]
        );
    }

    public function getMostRecentGear()
    {
        $parent_categories = $this->getGearParentCategories();
        $gear_categories = $this->gateway->getCol("gear_category_id", "gear_categories", ["parent_category_id" => ["IN", $parent_categories]]);

        $accessory = $this->gateway->getRow(
            ["gear", "abbr", "page"],
            "gear INNER JOIN books USING (book_id)",
            ["gear_category_id" => ["IN", $gear_categories]],
            ["gear_id DESC"]
        );

        return $accessory != false
            ? $accessory["gear"] . " (p. " . $accessory["abbr"] . ", " . $accessory["page"] . ")"
            : false;
    }

    protected function getGearParentCategories()
    {
        return $this->gateway->getCol("gear_category_id", "gear_categories", ["gear_category" => "Firearms Accessories"]);
    }

    /**
     * @param Filter $filter
     * @throws DomainException
     */
    protected function setFilter(Filter $filter)
    {
        if ($filter instanceof WeaponAccessoriesFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof WeaponAccessoriesFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof WeaponAccessoriesGateway) $this->gateway = $gateway;
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
