<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\WeaponAccessories;

use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Exceptions\EntityException;
use Shadowlab\Domains\Cheatsheets\Gear\GearGateway;

class WeaponAccessoriesGateway extends GearGateway
{
    public function select(array $entities = null)
    {
        return $entities == null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        return [];
    }

    protected function selectSome(array $entities)
    {
        return $entities;
    }

    public function insert(Entity $entity)
    {
        $gear_id = parent::insert($entity);
        if ($gear_id !== false) {

            // as long as the parent's insert() method could give us a gear_id, we know that we've
            // inserted the accessory into the database.  but, the default means by which we store
            // attribute information won't work for us because a single accessory could have multiple
            // mounting points.  therefore, we'll handle that stuff here.

            $mounts = $entity->get("mounts");
            if (is_array($mounts) && sizeof($mounts) > 0) {
                $attribute_id = $this->getVar("attribute_id", "attributes", [
                    "category"  => "weapon accessory",
                    "attribute" => "mount",
                ]);

                $database = $this->db->getDatabase();
                $this->db->setDatabase("dashifen_shadowlab");
                $format = "SELECT mount FROM gear_mounts WHERE mount_id=%d";
                foreach ($mounts as $mount_id) {
                    $reference = sprintf($format, $mount_id);
                    $this->db->insert("gear_attributes", [
                        "gear_id"      => $gear_id,
                        "attribute_id" => $attribute_id,
                        "reference"    => $reference,
                    ]);
                }

                $this->db->setDatabase($database);
            }
        }

        return $gear_id;
    }

    protected function confirmEntity(Entity $entity)
    {
        if (!($entity instanceof WeaponAccessoriesEntity)) {
            throw new EntityException("Unexpected entity:  " . get_class($entity));
        }

        return true;
    }
}
