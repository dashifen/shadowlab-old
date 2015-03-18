<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Spirits;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class SpiritsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|SpiritsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    public function selectAll()
    {
        $properties = SpiritsEntity::getProperties();

        // our spirits are more problematic than some other data that we display on-screen
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

        $spirits = $this->db->getResults(
            $critter_data,
            "critters INNER JOIN books USING (book_id)",
            ["critter_type" => "spirit"],
            ["critter"]);

        // now, for each of our spirits, we have to get their attributes, skills, and powers.
        // these data change for each sprite (i.e. not all sprites will have the same Firewall
        // attribute) so we'll loop over our $sprites array and add more information as we go.

        foreach ($spirits as &$spirit) {
            $critter_id = $spirit["critter_id"];

            $spirit["attributes"] = $this->db->getMap(
                ["attribute", "rating"],
                "critters_attributes INNER JOIN attributes USING (attribute_id)",
                ["AND", ["OR", ["AND", "attribute"=>["!=","resonance"], "category"=>["IN", ["physical","mental","special"]]], ["attribute"=>"essence"]], ["critter_id"=>$critter_id]],
                ["FIELD(attribute,'body','agility','reaction','strength','willpower','logic','intuition','charisma','essence','magic','edge')"]
            );

            $spirit["skills"] = $this->db->getVar(
                "GROUP_CONCAT(skill ORDER BY skill SEPARATOR ', ') AS skills",
                "critters_skills INNER JOIN skills USING (skill_id)",
                ["critter_id" => $critter_id]
            );

            $spirit["powers"] = $this->db->getCol(
                "critter_power",
                "critter_powers
                    INNER JOIN critters_critter_powers USING (critter_power_id)
                    INNER JOIN critters USING (critter_id)",
                [ "critter_id" => $critter_id, "optional" => "N" ],
                [ "critter_power" ]
            );

            $spirit["opt_powers"] = $this->db->getCol(
                "critter_power",
                "critter_powers
                    INNER JOIN critters_critter_powers USING (critter_power_id)
                    INNER JOIN critters USING (critter_id)",
                [ "critter_id" => $critter_id, "optional" => "Y" ],
                [ "critter_power" ]
            );
        }

        $this->db->setDatabase($old_db);
        return $spirits;
    }

    public function selectSome(array $entities)
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
