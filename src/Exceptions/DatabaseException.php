<?php

namespace Shadowlab\Exceptions;

class DatabaseException extends \Exception
{
    /**
     * @var string $query;
     */
    protected $query;

    public function __construct($message, $query='', \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->setQuery($query);
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }
}
