<?php

namespace Shadowlab\Interfaces\Domain;

use Shadowlab\Exceptions\FilterException;
use Shadowlab\Exceptions\EntityException;

abstract class AbstractFilter implements Filter
{
    /**
     * @var Entity
     */
    protected $entity;

    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var array
     */
    protected $errors = [];

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getError($key = null)
    {
        if (isset($this->errors[$key])) {
            return $this->errors[$key];
        }

        return null;
    }

    /**
     * @param Entity $entity
     * @param Domain $domain
     * @param string $action
     * @return bool
     * @throws EntityException
     * @throws FilterException
     */
    public function validate(Entity $entity, Domain $domain, $action = "insert")
    {
        $this->setEntity($entity);
        $this->setDomain($domain);
        $method = $this->confirmAction($action);
        $this->{$method}();

        // our filter methods (below) all use $this->entity to set $this->errors as necessary.
        // therefore, all we need to do here is to return $this->isValid() to the calling
        // scope.

        return $this->isValid();
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return sizeof($this->errors) == 0;
    }

    /**
     * @param $action
     * @return string
     * @throws FilterException
     */
    public function confirmAction($action)
    {
        $method = "filter" . ucfirst(strtolower($action));

        if (!method_exists($this, $method)) {
            throw new FilterException("Unknown action: $action");
        }

        return $method;
    }

    abstract protected function setDomain(Domain $domain);
    abstract public function setEntity(Entity $entity);
    abstract public function filterSelect();
    abstract public function filterInsert();
    abstract public function filterUpdate();
    abstract public function filterDelete();
}
