<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShotsLocations;

use Aura\View\Exception;
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
class CalledShotsLocations extends AbstractDomain
{
    /**
     * @var CalledShotsLocationsFilter
     */
    protected $filter;

    /**
     * @var CalledShotsLocationsFactory
     */
    protected $factory;

    /**
     * @var CalledShotsLocationsGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function getCalledShotsLocations()
    {
        try {
            $locations = $this->gateway->select();
            return $locations !== false
                ? $this->payload->found([ 'locations' => $locations ])
                : $this->payload->notFound([ 'locations' => '' ]);
        } catch (\Exception $e) {
            return $this->payload->error([ 'exception' => $e ]);
        }
    }

    /**
     * @param Filter $filter
     * @throws DomainException
     */
    protected function setFilter(Filter $filter)
    {
        if ($filter instanceof CalledShotsLocationsFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof CalledShotsLocationsFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof CalledShotsLocationsGateway) $this->gateway = $gateway;
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
