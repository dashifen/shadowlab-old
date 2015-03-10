<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\IntrusionCountermeasures;

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
class IntrusionCountermeasures extends AbstractDomain
{
    /**
     * @var IntrusionCountermeasuresFilter
     */
    protected $filter;

    /**
     * @var IntrusionCountermeasuresFactory
     */
    protected $factory;

    /**
     * @var IntrusionCountermeasuresGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function getIC()
    {
        // getting all of our actions is as easy as telling our gateway to select 'em.  the gateway will
        // distinguish between the selection of a specific action and all of them behind the scenes within
        // its select() method.  by not passing an action's ID number, we'll trigger the selection of the
        // entire set.

        try {
            $countermeasures = $this->gateway->select();

            // if we didn't find any actions (which, frankly we really should have since we're getting
            // all of them) then we'll return an empty NotFound Payload.  the Responder will know what
            // to do with it.

            return $countermeasures !== false
                ? $this->payload->found([ "countermeasures" => $countermeasures ])
                : $this->payload->notFound([ "countermeasures" => [] ]);
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
        if ($filter instanceof IntrusionCountermeasuresFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof IntrusionCountermeasuresFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof IntrusionCountermeasuresGateway) $this->gateway = $gateway;
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
