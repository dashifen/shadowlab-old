<?php

namespace Shadowlab\Domains\Cheatsheets\Matrix\ComplexForms;

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
class ComplexForms extends AbstractDomain
{
    /**
     * @var ComplexFormsFilter
     */
    protected $filter;

    /**
     * @var ComplexFormsFactory
     */
    protected $factory;

    /**
     * @var ComplexFormsGateway
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
    public function getComplexForms()
    {
        try {
            $forms = $this->gateway->select();

            return $forms !== false
                ? $this->payload->found([ "forms" => $forms ])
                : $this->payload->notFound([ "forms" => [] ]);

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
        if ($filter instanceof ComplexFormsFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof ComplexFormsFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof ComplexFormsGateway) $this->gateway = $gateway;
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
