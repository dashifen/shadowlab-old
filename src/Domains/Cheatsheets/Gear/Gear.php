<?php

namespace Shadowlab\Domains\Cheatsheets\Gear;

use Aura\View\Exception;
use Shadowlab\Exceptions\DatabaseException;
use Shadowlab\Interfaces\Domain\AbstractDomain;

abstract class Gear extends AbstractDomain
{
    abstract public function getGearCategories();
    abstract public function getGearAttributes();
    abstract public function getMostRecentGear();
    abstract protected function getGearParentCategories();

    /**
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function select()
    {
        try {
            $gear = $this->gateway->select();

            return $gear !== false
                ? $this->payload->found(["gear" => $gear ])
                : $this->payload->notFound(["gear" => "" ]);

        } catch (\Exception $e) {
            return $this->payload->error(["exception" => $e ]);
        }
    }

    /**
     * @param array $post
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function insert(array $post)
    {
        $gear  = $this->factory->newEntity($post);
        $valid = $this->filter->validate($gear, $this, "insert");

        // if $valid is not true, then we can simply return a notValid payload along with the
        // errors that our filter identified.  we also pass back the posted values which we could
        // grab in our action, but it's just as easy to send them as a part of the payload here.

        if (!$valid) {
            return $this->payload->notValid([
                "errors" => $this->filter->getErrors(),
                "values" => $gear->getAll(),
            ]);
        }

        // if we didn't return, then we need to try and insert our $ritual into the database.  we can
        // pass the entity over to the gateway object and it'll take over from there.  then, based on
        // whether or not we were successful in our insertion, we'll send back a created or notCreated
        // payload.

        try {
            $success = $this->gateway->insert($gear);
        } catch (DatabaseException $e) {
            return $this->payload->error([
                "values"    => $gear->getAll(),
                "exception" => $e
            ]);
        }

        return !$success
            ? $this->payload->notCreated(["error" => $this->gateway->getError(), "values" => $gear->getAll()])
            : $this->payload->created(["gear_id" => $success, "values" => $gear->getAll()]);
    }
}
