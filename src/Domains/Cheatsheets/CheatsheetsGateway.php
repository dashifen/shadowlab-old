<?php

namespace Shadowlab\Domains\Cheatsheets;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class CheatsheetsGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|CheatsheetsEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        $sheets = [];

        if($entities === null) {
            throw new EntityException("Entities shouldn't be null");
        }

        foreach ($entities as $entity) {
            if ($entity instanceof CheatsheetsEntity) {

                // to select our list of cheatsheets from the database, our $entity may specify a type to
                // grab.  if so, we'll use it as a criterion for our SELECT query.  otherwise, we'll just
                // select them all.

                $data = $entity->getAll();
                $data = array_filter($data, function($x) { return !empty($x); });
                $cols = ['cheatsheet_id', 'cheatsheet_type','cheatsheet_name'];
                $temp = $this->db->getResults($cols, 'cheatsheets', $data, array_slice($cols, 1));

                // to avoid sending back the same sheet more than once, we'll real quick loop over our list
                // of sheets and add them to the $sheets array only if they haven't already been added.  at
                // this time, our system only selects either all of the sheets or all sheets with a specific
                // type, so we don't need to worry about this step un-ordering our list of sheets.

                foreach ($temp as $sheet) {
                    if (!isset($sheets[$sheet['cheatsheet_id']])) {
                        $sheets[$sheet['cheatsheet_id']] = $sheet;
                    }
                }
            } else {
                throw new EntityException("Unexpected entity: " . get_class($entity));
            }
        }

        return $sheets;
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
