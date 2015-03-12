<?php

namespace Shadowlab\Domains\Cheatsheets\Other\Qualities;

use Shadowlab\Exceptions\DomainException;
use Shadowlab\Interfaces\Domain\Filter;
use Shadowlab\Interfaces\Domain\Gateway;
use Shadowlab\Interfaces\Domain\Factory;
use Shadowlab\Interfaces\Domain\Payloads\PayloadFactory;
use Shadowlab\Interfaces\Domain\AbstractDomain;

/**
 * Class User
 * @package Shadowlab\Domains\User
 */
class Qualities extends AbstractDomain
{
    /**
     * @var QualitiesFilter
     */
    protected $filter;

    /**
     * @var QualitiesFactory
     */
    protected $factory;

    /**
     * @var QualitiesGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function getQualities()
    {
        try {
            $qualities = $this->gateway->select();

            return $qualities !== false
                ? $this->payload->found([ "qualities" => $qualities ])
                : $this->payload->notFound([ "qualities" => [] ]);

        } catch (\Exception $e) {

            return $this->payload->error([
                "exception" => $e
            ]);

        }
    }



    /**
     * @param Filter $filter
     * @throws DomainException
     */
    protected function setFilter(Filter $filter)
    {
        if ($filter instanceof QualitiesFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof QualitiesFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof QualitiesGateway) $this->gateway = $gateway;
        else throw new DomainException("Unexpected gateway: " . get_class($gateway));
    }

    /**
     * @param PayloadFactory $payload
     */
    protected function setPayload(PayloadFactory $payload)
    {
        $this->payload = $payload;
    }
}
