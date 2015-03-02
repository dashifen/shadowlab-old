<?php

namespace Shadowlab\Interfaces\Domain;

abstract class AbstractFilter implements Filter
{
    protected $entity;
    protected $errors = [];

    public function getErrors()
    {
        return $this->errors;
    }

    public function isValid()
    {
        return sizeof($this->errors)==0;
    }

    abstract public function setEntity(Entity $entity);
    abstract public function filterSelect();
    abstract public function filterInsert();
    abstract public function filterUpdate();
    abstract public function filterDelete();
    abstract public function validate();
}
