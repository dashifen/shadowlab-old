<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\SpritePowers;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class SpritePowersGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|SpritePowersEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $old_db = $this->db->getDatabase();
        $properties = SpritePowersEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $this->db->setDatabase("dashifen_shadowlab");

        // we haven't added sub-queries to our database object yet so before we can select the list of
        // powers that are associated specifically with sprites.

        $IDs = $this->db->getCol(
            "DISTINCT critter_power_id",
            "critters_critter_powers INNER JOIN critters USING (critter_id)",
            ["critter_type" => "sprite"]
        );

        $powers = $this->db->getResults(
            $properties,
            "critter_powers INNER JOIN books USING (book_id)",
            [ "critter_power_id" => [ "IN", $IDs ] ],
            [ "critter_power "]
        );

        $this->db->setDatabase($old_db);
        return $powers;
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
