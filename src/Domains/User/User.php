<?php

namespace Shadowlab\Domains\User;

use Shadowlab\Exceptions\DomainException;
use Shadowlab\Exceptions\EntityException;
use Shadowlab\Interfaces\Domain\Filter;
use Shadowlab\Interfaces\Domain\Gateway;
use Shadowlab\Interfaces\Domain\Factory;
use Shadowlab\Interfaces\Domain\Payloads\PayloadFactory;
use Shadowlab\Interfaces\Domain\AbstractDomain;

/**
 * Class User
 * @package Shadowlab\Domains\User
 */
class User extends AbstractDomain
{
    /**
     * @var UserFilter
     */
    protected $filter;

    /**
     * @var UserFactory
     */
    protected $factory;

    /**
     * @var UserGateway
     */
    protected $gateway;

    /**
     * @var PayloadFactory
     */
    protected $payload;

    /**
     * @param $username
     * @param $password
     * @return \Shadowlab\Interfaces\Domain\Payload
     **/
    public function authenticate($username, $password)
    {
        $record = "";

        try {
            // to authenticate a user, we create an entity out of the username we've received.
            // then, we'll see if we can find it in the database.

            $entity = $this->factory->newEntity(['username' => $username]);
            $record = $this->gateway->select([$entity]);
            if ($record !== false) {

                // if we did find a record for the specified user, we'll need to see if the hashed
                // version of the password in the database matches the $password that the visitor entered.

                $is_authentic = password_verify($password, $record['password']);
                if ($is_authentic) return $this->payload->found(['user' => $record]);
            }
        } catch (EntityException $e) {
            return $this->payload->error([
                "exception" => $e,
                "username"  => $username,
                "record"    => $record
            ]);
        }

        return $this->payload->notFound(['username' => $username]);
    }

    public function lookUp(array $data = [])
    {
        // given an array of $data that describes a user, we want to create an UserEntity and
        // then see if we can find a record of that entity in the database.  if so, then we can
        // return that payload to the

        try {
            $entity = $this->factory->newEntity($data);
            $record = $this->gateway->select([$entity]);
            $payload = $record !== false
                ? $this->payload->found(["user" => $record])
                : $this->payload->notFound([]);
        } catch (EntityException $e) {
            $payload = $this->payload->error([
                "exception" => $e,
                "data"      => $data
            ]);
        }

        return $payload;
    }

    /**
     * @param Filter $filter
     * @throws DomainException
     */
    protected function setFilter(Filter $filter)
    {
        if ($filter instanceof UserFilter) $this->filter = $filter;
        else throw new DomainException("Unexpected filter: " . get_class($filter));
    }

    /**
     * @param Factory $factory
     * @throws DomainException
     */
    protected function setFactory(Factory $factory)
    {
        if ($factory instanceof UserFactory) $this->factory = $factory;
        else throw new DomainException("Unexpected factory: " . get_class($factory));
    }

    /**
     * @param Gateway $gateway
     * @throws DomainException
     */
    protected function setGateway(Gateway $gateway)
    {
        if ($gateway instanceof UserGateway) $this->gateway = $gateway;
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
