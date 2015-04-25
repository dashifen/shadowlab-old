<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\MentorSpirits;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class MentorSpiritsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|MentorSpiritsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        // if our $entries argument is null, then we want to select all of the spells in the database
        // for display as a full cheatsheet.  otherwise, we use $entries to select some of our spells,
        // usually just one, for editing.

        return $entities === null ? $this->selectAll() : $this->selectSome($entities);
    }

    protected function selectAll()
    {
        $properties = MentorSpiritsEntity::getProperties();
        array_walk($properties, [$this, "ticker"]);

        $original_db = $this->db->getDatabase();
        $this->db->setDatabase("dashifen_shadowlab");
        $mentors = $this->db->getResults($properties, "mentor_spirits INNER JOIN books USING (book_id)", [],
            ["mentor_spirit"]);

        foreach ($mentors as &$mentor) {
            $mentor["alternatives"] = $this->db->getCol("other", "mentor_spirits_others",
                ["mentor_spirit_id" => $mentor["mentor_spirit_id"]], ["other"]);
        }

        $this->db->setDatabase($original_db);

        return $mentors;
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
