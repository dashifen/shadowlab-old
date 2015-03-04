<?php

namespace Shadowlab\Domains\User;

use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Entity;
use Shadowlab\Interfaces\Domain\AbstractGateway;

class UserGateway extends AbstractGateway
{
    /**
     * @param array $entities
     * @return array|UserEntity|bool
     * @throws EntityException
     */
    public function select(array $entities = null)
    {
        $users = [];

        if($entities === null) {
            throw new EntityException("Entities shouldn't be null");
        }

        foreach($entities as $entity) {
            if ($entity instanceof UserEntity) {
                // if we have a UserEntity, then we want to select the user in the database
                // which matches its data.  we'll get all of its data and then filter out any
                // that are empty.  then, we try to get everything the database knows about any
                // user that matches the remaining information.  if we can do so, we add it to
                // the $users array.  this allows us to, for example, receive a username and
                // password and return the user account that matches them.

                $data = $entity->getAll();
                $data = array_filter($data, function($datum) { return !empty($datum); });
                $user = $this->db->getRow(['*'], "users", $data);
                if($user !== false) $users[] = $user;
            } else {
                throw new EntityException("Unexpected Entity: " . get_class($entity));
            }
        }

        $retval = false;
        if (sizeof($users)==1) $retval = $users[0];
        elseif (sizeof($users)>1) $retval = $users;
        return $retval;
    }

    /**
     * @param Entity $entity
     * @return int|bool
     * @throws EntityException
     */
    public function insert(Entity $entity)
    {
        if (!($entity instanceof UserEntity)) {
            $values = $entity->getAllExcept(['user_id']);
            $user_id = $this->db->insert("users", $values);
            return $user_id;
        }

        // if we didn't return in the if-block above, we didn't have the
        // right type of entity.  therefore, we'll throw an exception.  this
        // pattern repeats for the methods below.

        throw new EntityException("Unexpected Entity: " . get_class($entity));
    }

    /**
     * @param Entity $entity
     * @return int|bool
     * @throws EntityException
     */
    public function update(Entity $entity)
    {
        if (!($entity instanceof UserEntity)) {
            $values = $entity->getAllExcept(['user_id']);
            $key = ['user_id' => $entity->get('user_id')];
            $success = $this->db->update("users", $values, $key);
            return $success;
        }

        throw new EntityException("Unexpected Entity: " . get_class($entity));
    }

    /**
     * @param Entity $entity
     * @return bool
     * @throws EntityException
     */
    public function delete(Entity $entity)
    {
        if (!($entity instanceof UserEntity)) {
            $key = ['user_id' => $entity->get('user_id')];
            $success = $this->db->delete("users", $key, 1);
            return $success;
        }

        throw new EntityException("Unexpected Entity: " . get_class($entity));
    }
}
