<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\Programs;

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
class Programs extends AbstractDomain
{
    /**
     * @var ProgramsFilter
     */
    protected $filter;

    /**
     * @var ProgramsFactory
     */
    protected $factory;

    /**
     * @var ProgramsGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function getPrograms()
    {
        try {
            $programs = $this->gateway->select();

            return $programs !== false
                ? $this->payload->found([ "programs" => $programs ])
                : $this->payload->notFound([ "programs" => [] ]);

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
        if ($filter instanceof ProgramsFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof ProgramsFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof ProgramsGateway) $this->gateway = $gateway;
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
