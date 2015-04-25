<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Rituals;

use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;
use Shadowlab\Exceptions\DatabaseException;
use Shadowlab\Exceptions\EntityException;

class RitualsGateway extends AbstractGateway
{
    public function select(array $entities = null)
    {
        return $entities == null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $properties = RitualsEntity::getProperties(["ritual_tags"]);
        array_walk($properties, [$this, "ticker"]);

        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $rituals = $this->db->getResults($properties, "rituals INNER JOIN books USING (book_id)", [], ["ritual"]);

        foreach ($rituals as &$ritual) {
            $ritual["ritual_tags"] = $this->db->getMap(
                ["ritual_tag_id", "ritual_tag"],
                "rituals_ritual_tags INNER JOIN rituals_tags USING (ritual_tag_id)",
                ["ritual_id" => $ritual["ritual_id"]],
                ["ritual_tag"]
            );

            $ritual["prerequisite_metamagic"] = is_numeric($ritual["prerequisite_metamagic_id"])
                ? $this->db->getVar("metamagic", "metamagics", ["metamagic_id" => $ritual["prerequisite_metamagic_id"]])
                : "";

            $ritual["prerequisite_metamagic_school"] = is_numeric($ritual["prerequisite_metamagic_school_id"])
                ? $this->db->getVar("school_name", "metamagics_schools", ["school_id" => $ritual["prerequisite_metamagic_school_id"]])
                : "";

            $ritual["prerequisite_ritual"] = is_numeric($ritual["prerequisite_ritual_id"])
                ? $this->db->getVar("ritual", "rituals", ["ritual_id" => $ritual["prerequisite_ritual_id"]])
                : "";
        }

        $this->db->setDatabase($original_db);
        return $rituals;
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

            // to insert a ritual, we first have to add information to the rituals table.  that will
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
        if (!($entity instanceof RitualsEntity)) {
            throw new EntityException("Unexpected entity:  " . get_class($entity));
        }

        return true;
    }
}
