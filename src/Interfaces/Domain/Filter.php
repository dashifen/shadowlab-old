<?php

namespace Shadowlab\Interfaces\Domain;

interface Filter
{
    public function getErrors();
    public function getError($key = null);
    public function setEntity(Entity $entity);
    public function validate(Entity $entity, Domain $domain, $action = "insert");
    public function confirmAction($action);
    public function filterSelect();
    public function filterInsert();
    public function filterUpdate();
    public function filterDelete();
    public function isValid();
}
