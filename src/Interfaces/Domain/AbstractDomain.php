<?php

namespace Shadowlab\Interfaces\Domain;

use Shadowlab\Interfaces\Domain\Payloads\PayloadFactory;

abstract class AbstractDomain implements Domain
{
    protected $filter;
    protected $factory;
    protected $gateway;
    protected $payload;

    public function __construct(
        Filter $filter,
        Factory $factory,
        Gateway $gateway,
        PayloadFactory $payload
    ) {
        $this->setFilter($filter);
        $this->setFactory($factory);
        $this->setGateway($gateway);
        $this->setPayload($payload);
    }

    /**
     * @return Payload|null
     */
    public function getPayload($type)
    {
        return method_exists($this->payload, $type)
            ? $this->payload->$type()
            : null;
    }

    abstract protected function setFilter(Filter $filter);
    abstract protected function setFactory(Factory $factory);
    abstract protected function setGateway(Gateway $gateway);
    abstract protected function setPayload(PayloadFactory $payload);
}
