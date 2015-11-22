<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\Vehicles;

use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Exceptions\EntityException;
use Shadowlab\Domains\Cheatsheets\Gear\GearGateway;

class VehiclesGateway extends GearGateway
{
    public function select(array $entities = null)
    {
        return $entities == null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $database = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $properties = VehiclesEntity::getProperties(["attributes"]);

        $parents = $this->db->getCol("gear_category_id", "gear_categories", ["gear_category" => ["IN", ["Vehicles", "Drones"]]]);
        $categories = $this->db->getCol("gear_category_id", "gear_categories", ["parent_category_id" => ["IN", $parents]]);

        $vehicles = $this->db->getResults($properties, "gear INNER JOIN books USING (book_id)",
            ["gear_category_id" => ["IN", $categories]],
            ["gear"]
        );

        foreach ($vehicles as &$vehicle) {
            $vehicle["attributes"] = $this->getResults(
                ["attribute", "abbr", "rating"],
                "gear_attributes INNER JOIN attributes USING (attribute_id)",
                ["gear_id" => $vehicle["gear_id"]],
                ["attribute_order"]
            );

            $categories = $this->getRow(
                ["child.gear_category category", "parent.gear_category parent"],
                "gear INNER JOIN gear_categories child ON child.gear_category_id = gear.gear_category_id "
                    . "INNER JOIN gear_categories parent ON parent.gear_category_id = child.parent_category_id",

                ["gear_id" => $vehicle["gear_id"]]
            );

            $vehicle = array_merge($vehicle, $categories);
        }

        $this->db->setDatabase($database);
        return $vehicles;
    }

    protected function selectSome(array $entities)
    {

        return [];
    }

    protected function confirmEntity(Entity $entity)
    {
        if (!($entity instanceof VehiclesEntity)) {
            throw new EntityException("Unexpected entity:  " . get_class($entity));
        }

        return true;
    }
}
