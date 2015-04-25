<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShotsLocations;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class CalledShotsLocationsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|CalledShotsLocationsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $properties = CalledShotsLocationsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $locations = $this->db->getResults($properties,
            "called_shots_locations INNER JOIN books USING (book_id)",
            [], ["location"]);

        foreach ($locations as &$location) {
            if (empty($location["effect"])) {

                // if the primary effect of a shot to a specific target is empty, then we want to get the
                // more specific effects out of the called_shots_locations_effects table as follows.

                $location["effect"] = $this->db->getResults(
                    ["called_shots_effects.effect", "called_shots_locations_effects.effect AS description"],
                    "called_shots_locations_effects INNER JOIN called_shots_effects USING (effect_id)",
                    ["location_id" => $location["location_id"]],
                    ["called_shots_effects.effect"]
                );
            }
        }

        $this->db->setDatabase($original_db);
        return $locations;
    }

    protected function selectSome(array $entities)
    {

    }

    public function insert(Entity $entity)
    {

    }

    public function update(Entity $entity)
    {

    }

    public function delete(Entity $entity)
    {

    }
}
