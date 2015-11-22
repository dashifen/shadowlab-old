<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\Weapons;

use Aura\View\Exception;
use Shadowlab\Interfaces\Domain\Filter;
use Shadowlab\Interfaces\Domain\Gateway;
use Shadowlab\Interfaces\Domain\Factory;
use Shadowlab\Exceptions\DomainException;
use Shadowlab\Interfaces\Domain\Payloads\PayloadFactory;
use Shadowlab\Domains\Cheatsheets\Gear\Gear;

class Weapons extends Gear
{
    /**
     * @var WeaponsFilter
     */
    protected $filter;

    /**
     * @var WeaponsFactory
     */
    protected $factory;

    /**
     * @var WeaponsGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    public function getWeapons()
    {
        try {
            $weapon = $this->gateway->select();

            return $weapon !== false
                ? $this->payload->found(["weapon" => $weapon])
                : $this->payload->notFound(["weapon" => ""]);

        } catch (\Exception $e) {
            return $this->payload->error(["exception" => $e]);
        }
    }

    public function getFormData()
    {
        return [
            "categories" => $this->getGearCategories(),
            "attributes" => $this->getGearAttributes(),
            "weapon"     => $this->getMostRecentGear(),
            "books"      => $this->getBooks(),
        ];
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
        return $this->gateway->getMap(["attribute_id", "attribute"], "attributes", ["category" => "weapon"], ["attribute_order"]);
    }

    public function getMostRecentGear()
    {
        $parent_categories = $this->getGearParentCategories();
        $gear_categories = $this->gateway->getCol("gear_category_id", "gear_categories", ["parent_category_id" => ["IN", $parent_categories]]);

        $weapon = $this->gateway->getRow(
            ["gear", "abbr", "page"],
            "gear INNER JOIN books USING (book_id)",
            ["gear_category_id" => ["IN", $gear_categories]],
            ["gear_id DESC"]
        );

        return $weapon != false
            ? $weapon["gear"] . " (p. " . $weapon["abbr"] . ", " . $weapon["page"] . ")"
            : false;
    }

    protected function getGearParentCategories()
    {
        return $this->gateway->getCol("gear_category_id", "gear_categories", [
            "gear_category" => ["IN", ["Ranged Weapons", "Projectile/Throwing Weapons", "Melee Weapons"]]
        ]);
    }

    /**
     * @param Filter $filter
     * @throws DomainException
     */
    protected function setFilter(Filter $filter)
    {
        if ($filter instanceof WeaponsFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof WeaponsFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof WeaponsGateway) $this->gateway = $gateway;
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
