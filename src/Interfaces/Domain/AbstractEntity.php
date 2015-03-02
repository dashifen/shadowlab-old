<?php

namespace Shadowlab\Interfaces\Domain;

use Shadowlab\Exceptions\EntityException;

abstract class AbstractEntity implements Entity
{
    public function get($key)
    {
        $retval = null;

        if (property_exists($this, $key)) {
            $retval = $this->{$key};
        }

        return $retval;
    }

    public function set($key, $value)
    {
        if(property_exists($this, $key)) {
            $this->{$key} = $value;
        } else {
            throw new EntityException("Unknown entity: " . $key);
        }
    }

    public function getAll()
    {
        return get_object_vars($this);
    }

    public function getAllExcept(array $except)
    {
        $properties = $this->getAll();

        foreach ($except as $property) {
            if (isset($properties[$property])) {
                unset($properties[$property]);
            }
        }

        return $properties;
    }

    public function setAll(array $properties)
    {
        $skipped = array();

        foreach ($properties as $key => $value) {
            try {
                $this->set($key, $value);
            } catch (EntityException $e) {
                $skipped[$key] = $value;
            }
        }

        if (sizeof($skipped) > 0) {
            $skipped = join(", ", array_keys($skipped));
            throw new EntityException("Unknown entities: " . $skipped);
        }

        return true;
    }
}
