<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShotsAmmo;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class CalledShotsAmmoGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|CalledShotsAmmoEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    public function selectAll()
    {
        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $properties = CalledShotsAmmoEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        // because we join the enhancements and the called_shots tables, we end up with a few columns named
        // the same.  therefore, we need to fully qualify which one we care about right now.

        foreach ($properties as &$property) {
            if ($property == "`description`" || $property == "`page`" || $property == "`book_id`") {
                $property = "`called_shots_enhancements`." . $property;
            }
        }


        $shots = $this->db->getResults($properties,
            "called_shots_enhancements LEFT JOIN called_shots USING (called_shot_id) "
                . "INNER JOIN books ON called_shots_enhancements.book_id = books.book_id",
            [],
            ["enhancement"]);

        foreach($shots as &$shot) {
            if (empty($shot["effect"])) {

                // when the effect column of a called shot enhancement is empty then the effects are
                // stored in the called_shots_enhancements_effects table.  we'll select those data here
                // for use on-screen.

                $shot["effects"] = $this->db->getResults(
                    ["called_shots_effects.effect", "called_shots_enhancements_effects.effect AS description"],
                    "called_shots_enhancements_effects INNER JOIN called_shots_effects USING (effect_id)",
                    ["enhancement_id" => $shot["enhancement_id"]],
                    ["called_shots_effects.effect"]
                );
            }
        }

        $this->db->setDatabase($original_db);
        return $shots;
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
