<?php

namespace Shadowlab\Interfaces\Domain;

interface Filter
{
    public function getErrors();
    public function setEntity(Entity $entity);
    public function filterSelect();
    public function filterInsert();
    public function filterUpdate();
    public function filterDelete();
    public function validate();
    public function isValid();
}
