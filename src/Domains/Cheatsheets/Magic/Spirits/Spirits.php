<?php

namespace Shadowlab\Domains\Cheatsheets\Magic\Spirits;

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
class Spirits extends AbstractDomain
{
    /**
     * @var SpiritsFilter
     */
    protected $filter;

    /**s
     * @var SpiritsFactory
     */
    protected $factory;

    /**
     * @var SpiritsGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function getSpirits()
    {
        try {
            $spirits = $this->gateway->select();
            return $spirits !== false
                ? $this->payload->found([ 'spirits' => $spirits ])
                : $this->payload->notFound([ 'spirits' => '' ]);
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
        if ($filter instanceof SpiritsFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof SpiritsFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof SpiritsGateway) $this->gateway = $gateway;
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
