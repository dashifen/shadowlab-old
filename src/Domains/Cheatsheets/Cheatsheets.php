<?php

namespace Shadowlab\Domains\Cheatsheets;

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
class Cheatsheets extends AbstractDomain
{
    /**
     * @var CheatsheetsFilter
     */
    protected $filter;

    /**
     * @var CheatsheetsFactory
     */
    protected $factory;

    /**
     * @var CheatsheetsGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @param null $type
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function getCheatsheets($type = null)
    {
        try {
            $entity_data = [];
            if ($type != null) $entity_data['cheatsheet_type'] = $type;
            $entity = $this->factory->newEntity($entity_data);
            $sheets = $this->gateway->select([$entity]);

            // if we find sheets matching our entity, then we return them within a Found payload.  otherwise,
            // we'll return a notFound payload and simply specify the type.

            if ($sheets === false) return $this->payload->notFound(['type' => $type]);
            return $this->payload->found(['type' => $type, 'sheets' => $sheets]);
        } catch (\Exception $e) {
            return $this->payload->error([
                'type'      => $type,
                'exception' => $e
            ]);
        }
    }

    /**
     * @param Filter $filter
     * @throws DomainException
     */
    protected function setFilter(Filter $filter)
    {
        if ($filter instanceof CheatsheetsFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof CheatsheetsFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof CheatsheetsGateway) $this->gateway = $gateway;
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
