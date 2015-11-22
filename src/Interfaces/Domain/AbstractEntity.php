<?php

namespace Shadowlab\Interfaces\Domain;

use Shadowlab\Exceptions\EntityException;

/**
 * Class AbstractEntity
 * @package Shadowlab\Interfaces\Domain
 */
abstract class AbstractEntity implements Entity
{
    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        $retval = null;

        if (property_exists($this, $key)) {
            $retval = $this->{$key};
        }

        return $retval;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return get_object_vars($this);
    }

    /**
     * @param array $except
     * @return array
     */
    public function getAllExcept(array $except)
    {
        // this function returns the properties of this Entity except for those that are empty
        // or specified in the $except argument.  array_filter() can remove the empties and then
        // a foreach loop will do the rest.

        $properties = $this->getAll();
        $properties = array_filter($properties, function($x) { return !empty($x) || (is_numeric($x) && $x==0); });

        foreach ($except as $property) {
            if (isset($properties[$property])) {
                unset($properties[$property]);
            }
        }

        return $properties;
    }

    /**
     * @param $key
     * @param $value
     * @throws EntityException
     */
    public function set($key, $value)
    {
        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        } elseif ($key != "isPost") {
            throw new EntityException("Unknown property: " . $key);
        }
    }

    /**
     * @param $key
     * @param array $value
     * @throws EntityException
     */
    public function setArray($key, array $value = [])
    {
        // this is just a wrapper for the set() method with a type hint to be sure
        // that we get an array when we need one.

        $this->set($key, $value);
    }

    /**
     * @param $key
     * @param $index
     * @param $value
     * @throws EntityException
     */
    public function setArrayIndex($key, $index, $value)
    {
        if (property_exists($this, $key)) {
            if (!is_array($this->{$key})) {
                $this->{$key} = [];
            }

            $this->{$key}[$index] = $value;
        } else {
            throw new EntityException("Unknown property: " . $key);
        }
    }

    /**
     * @param array $properties
     * @return bool
     * @throws EntityException
     */
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
            throw new EntityException("Unknown property: " . $skipped);
        }

        return true;
    }

    /**
     * @param array $except
     * @return array
     */
    public static function getProperties(array $except = [])
    {
        $reflection = new \ReflectionClass(get_called_class());
        $properties = $reflection->getProperties();

        $temp = [];
        foreach ($properties as $property) {
            $property = $property->getName();
            if(array_search($property, $except)===false) $temp[] = $property;
        }

        return $temp;
    }
}
