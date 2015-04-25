<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\AdeptWays;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class AdeptWaysGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|AdeptWaysEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $original_db = $this->db->getDatabase();
        $properties = AdeptWaysEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $this->db->setDatabase("dashifen_shadowlab");

        $ways = $this->db->getResults($properties,
            "adept_ways INNER JOIN books USING (book_id)",
            [], ["adept_way"]);

        foreach ($ways as &$way) {
            $way["powers"] = $this->db->getCol(
                "adept_power",
                "adept_powers INNER JOIN adept_ways_powers USING (adept_power_id)",
                [ "way_id" => $way["way_id"] ],
                [ "adept_power" ]
            );
        }

        $this->db->setDatabase($original_db);
        return $ways;
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
