<?php

namespace Shadowlab\Domains\Cheatsheets\Gear\VehiclesAndDrones;

use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;
use Shadowlab\Exceptions\DatabaseException;
use Shadowlab\Exceptions\EntityException;

class VehiclesAndDronesGateway extends AbstractGateway
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

        return [];
    }

    /**
     * @param Entity $entity
     * @return bool
     * @throws EntityException
     * @throws DatabaseException
     */
    public function insert(Entity $entity)
    {
        $confirmed = $this->confirmEntity($entity);
        if ($confirmed) {
            $database = $this->db->getDatabase();
            $this->db->setDatabase("dashifen_shadowlab");

            // to insert a vehicle/drone, we first have to add information to the gear table.  that will
            // create for us a ritual ID that we can use to link in our ritual tags.

            $cols = $this->db->getColumns("rituals");
            $vals = $entity->getAllExcept(["ritual_tags"]);
            $ritual_id = $this->db->insert("rituals", $vals);
            if (!$ritual_id) return false;

            // now that we have a $ritual_id we can add our ritual tags to the database as well linking
            // these two sets of data.

            $tags = $entity->get("ritual_tags");
            if (is_array($tags) && sizeof($tags) > 0) {
                foreach ($tags as $tag) {
                    $this->db->insert("rituals_tags", [
                        "ritual_id"     => $ritual_id,
                        "ritual_tag_id" => $tag
                    ]);
                }
            }

            $this->db->setDatabase($database);
            return $ritual_id;
        }
    }

    public function update(Entity $entity)
    {

    }

    public function delete(Entity $entity)
    {


    }

    protected function confirmEntity(Entity $entity)
    {
        if (!($entity instanceof VehiclesAndDronesEntity)) {
            throw new EntityException("Unexpected entity:  " . get_class($entity));
        }

        return true;
    }
}
