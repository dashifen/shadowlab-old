<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\MartialArtsTechniques;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class MartialArtsTechniquesGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|MartialArtsTechniquesEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    public function selectAll()
    {
        $except = [ "styles" ];
        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $properties = MartialArtsTechniquesEntity::getProperties($except);
        array_walk($properties, [$this, "ticker"]);

        $techniques = $this->db->getResults($properties,
            "martial_arts_techniques INNER JOIN books USING (book_id)",
            [], ["technique"]);

        foreach ($techniques as &$technique) {
            $technique["styles"] = $this->db->getMap(
                ["martial_arts_styles_techniques.style_id", "style"],
                "martial_arts_styles_techniques INNER JOIN martial_arts_styles USING (style_id)",
                ["technique_id" => $technique["technique_id"]],
                ["style"]
            );

            if (empty($technique["description"])) {
                $technique["description"] = $this->db->getVar("description", $technique["table"],
                    [ $technique["primary_key"] => $technique["primary_key_value"] ]
                );
            }
        }

        $this->db->setDatabase($original_db);
        return $techniques;
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
