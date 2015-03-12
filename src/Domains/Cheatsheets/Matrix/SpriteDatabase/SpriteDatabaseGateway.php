<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class SpriteDatabaseGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|SpriteDatabaseEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $properties = SpriteDatabaseEntity::getProperties();

        // our sprites are more problematic than some other data that we display on-screen
        // because they have a mix of data from a variety of database tables.  we need to
        // gather it all and then send it back to the calling scope for use elsewhere.  first
        // we'll identify the information from our entity properties that can be found in the
        // critter table.

        $old_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $critter_columns = $this->db->getColumns("critters");
        $critter_columns = array_merge($critter_columns, $this->db->getColumns("books"));
        $critter_data = array_intersect($properties, $critter_columns);
        array_walk($critter_data, [$this, "ticker"]);

        $sprites = $this->db->getResults(
            $critter_data,
            "critters INNER JOIN books USING (book_id)",
            ["critter_type" => "sprite"],
            ["critter"]);

        // now, for each of our sprites, we have to get their attributes, skills, and powers.
        // these data change for each sprite (i.e. not all sprites will have the same Firewall
        // attribute) so we'll loop over our $sprites array and add more information as we go.

        foreach ($sprites as &$sprite) {
            $critter_id = $sprite["critter_id"];

            $sprite["attributes"] = $this->db->getMap(
                ["attribute", "rating"],
                "critters_attributes INNER JOIN attributes USING (attribute_id)",
                ["AND", ["OR", "attribute"=>"resonance", "category"=>"matrix"], ["critter_id" => $critter_id] ],
                [ "FIELD(attribute, 'attack', 'sleaze', 'data processing', 'firewall', 'resonance')" ]
            );

            $sprite["skills"] = $this->db->getVar(
                "GROUP_CONCAT(skill ORDER BY skill SEPARATOR ', ') AS skills",
                "critters_skills INNER JOIN skills USING (skill_id)",
                ["critter_id" => $critter_id]
            );

            $sprite["powers"] = $this->db->getCol(
                "critter_power",
                "critter_powers
                    INNER JOIN critters_critter_powers USING (critter_power_id)
                    INNER JOIN critters USING (critter_id)",
                [ "critter_id" => $critter_id ],
                [ "critter_power" ]
            );

        }

        $this->db->setDatabase($old_db);
        return $sprites;
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
