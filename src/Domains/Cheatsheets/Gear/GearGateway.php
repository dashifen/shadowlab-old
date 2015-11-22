<?php

namespace Shadowlab\Domains\Cheatsheets\Gear;

use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;
use Shadowlab\Exceptions\DatabaseException;

abstract class GearGateway extends AbstractGateway
{
    abstract protected function confirmEntity(Entity $entity);

    /**
     * @param Entity $entity
     * @return bool|int
     * @throws DatabaseException
     */
    public function insert(Entity $entity)
    {
        $gear_id = false;
        $confirmed = $this->confirmEntity($entity);

        if ($confirmed) {
            $database = $this->db->getDatabase();
            $this->db->setDatabase("dashifen_shadowlab");

            // to insert a piece of gear, we first have to add information to the gear table.  that will
            // create a gear ID for us that we can use to add any attributes that this item may have.  first
            // we get the columns from our gear table and compare that to the properties of our entity.  we
            // remove any properties that aren't in the gear table (i.e. the book's abbreviation) before we
            // do anything else.

            $cols = $this->db->getColumns("gear");
            $vals = $entity->getAllExcept(["attributes"]);

            foreach ($vals as $field => $value) {
                if (array_search($field, $cols)===false) {
                    unset($vals[$field]);
                }
            }

            // now, we can insert our gear into the database.  if we can't do so for some reason, we return
            // false to the calling scope and let it figure it out.

            $gear_id = $this->db->insert("gear", $vals);
            if (!$gear_id) return false;

            // now that we have a $gear_id we can add any attributes about this item into the gear_attributes
            // table.  that is, of course, if this item has any of them.

            $attributes = $entity->get("attributes");
            if (is_array($attributes) && sizeof($attributes) > 0) {
                foreach ($attributes as $attribute_id => $rating) {
                   if (is_numeric($rating)) {
                       $this->db->insert("gear_attributes", [
                           "gear_id" => $gear_id,
                           "attribute_id" => $attribute_id,
                           "rating" => $rating,
                       ]);
                   }
                }
            }

            $this->db->setDatabase($database);
        }

        return $gear_id;
    }

    public function update(Entity $entity)
    {
    }

    public function delete(Entity $entity)
    {
    }
}
