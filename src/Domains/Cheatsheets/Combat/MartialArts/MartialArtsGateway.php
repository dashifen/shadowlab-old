<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\MartialArts;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class MartialArtsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|MartialArtsEntity|bool
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
        $except = [ "techniques", "skill_group", "skill" ];
        $properties = MartialArtsEntity::getProperties($except);
        array_walk($properties, [$this, "ticker"]);

        $styles = $this->db->getResults($properties,
            "martial_arts_styles INNER JOIN books USING (book_id)",
            [], ["style"]);

        // in addition to the information we grabbed out of the styles table, we also need to grab
        // the following information per style to fill in the rest of the information.

        foreach ($styles as &$style) {
            $style["techniques"] = $this->db->getMap(
                ["martial_arts_styles_techniques.technique_id", "technique"],
                "martial_arts_styles_techniques INNER JOIN martial_arts_techniques USING (technique_id)",
                ["style_id" => $style["style_id"]],
                ["technique"]
            );

            $style["skill_group"] = $this->db->getVar("skill_group",
                "martial_arts_skills INNER JOIN skills_groups USING (skill_group_id)",
                ["style_id" => $style["style_id"]]
            );

            $style["skill"] = $this->db->getVar("skill",
                "martial_arts_skills INNER JOIN skills USING (skill_id)",
                ["style_id" => $style["style_id"]]
            );
        }

        $this->db->setDatabase($original_db);
        return $styles;
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
