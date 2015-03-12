<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\SpriteDatabase;

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
class SpriteDatabase extends AbstractDomain
{
    /**
     * @var SpriteDatabaseFilter
     */
    protected $filter;

    /**
     * @var SpriteDatabaseFactory
     */
    protected $factory;

    /**
     * @var SpriteDatabaseGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function getSprites()
    {
        try {
            $programs = $this->gateway->select();

            return $programs !== false
                ? $this->payload->found([ "sprites" => $programs ])
                : $this->payload->notFound([ "sprites" => [] ]);

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
        if ($filter instanceof SpriteDatabaseFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof SpriteDatabaseFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof SpriteDatabaseGateway) $this->gateway = $gateway;
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
