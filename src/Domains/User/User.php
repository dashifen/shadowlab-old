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

    /**
     * @param array $data
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function lookUp(array $data = [])
    {
        // given an array of $data that describes a user, we want to create an UserEntity and
        // then see if we can find a record of that entity in the database.  if so, then we can
        // return that payload to the

        try {
            $entity  = $this->factory->newEntity($data);
            $record  = $this->gateway->select([$entity]);

            if ($record != false) {
                $account = $this->factory->newEntity($record);
                $payload = $this->payload->found(["account" => $account]);
            } else {
                $payload = $this->payload->notFound(["account" => $entity]);
            }
        } catch (EntityException $e) {
            $payload = $this->payload->error([
                "exception" => $e,
                "data"      => $data
            ]);
        }

        return $payload;
    }

    /**
     * @param UserEntity $account
     * @param string $server
     * @return \Shadowlab\Interfaces\Domain\Payload
     * @throws EntityException
     */
    public function resetAccount(UserEntity $account, $server)
    {
        // to reset an account is to remove its password and to create a reset vector for it.  that
        // vector is then mailed to the owner of the account so that they can replace the password and
        // regain access to the ShadowLab.  to create our vector, we'll just grab 10 characters from
        // the md5 hash of a unique ID.

        $data = $account->getAllExcept(["password", "created_on", "last_update"]);

        $vector = substr(md5(uniqid("vector", true)), 0, 10);
        $data["reset_vector"] = $vector;
        $data["password"] = "NULL";

        $entity  = $this->factory->newEntity($data);
        $success = $this->gateway->update($entity);

        if ($success) {
            // when we've reset an account, we also need to send an email to the account's holder
            // related to this reset.

            $message_success = $this->emitter->emit("sendEmail", [
                "message"   => $this->getResetMessage($entity, $server),
                "recipient" => $account->get("email_address"),
                "subject"   => "ShadowLab Account Reset"
            ]);

            $payload = $this->payload->updated([
                "message" => $message_success,
                "account" => $entity,
            ]);
        } else {
            $payload = $this->payload->notUpdated(["account" => $entity]);
        }

        return $payload;
    }

    /**
     * @param UserEntity $entity
     * @param $server
     * @return string
     */
    protected function getResetMessage(UserEntity $entity, $server)
    {
        // the path to our Messages folder is below.  we go up three folders (into Domains then src and then
        // the application root folder) and then descend into the /ui/Messages folder.  in that folder, we grab
        // the contents of the reset.html file.

        $path = realpath(__DIR__ . "/../../../ui/Messages");
        $template = file_get_contents($path . "/reset.html");

        // within our $template are three variables:  username, url, and vector.  we pass the corresponding
        // values for those variables along with our $template into the convertTemplate method and then return
        // our parametrized message.

        $message = $this->convertTemplate($template, [
            "username" => $entity->get("username"),
            "url"      => "http://" . $server . "/accounts/reconfirm",
            "vector"   => $entity->get("reset_vector"),
        ]);

        return $message;
    }

    /**
     * @param UserEntity $account
     * @param string $reset_vector
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function confirmVector(UserEntity $account, $reset_vector)
    {
        // confirming that the account matches the reset vector is simple.  in fact, it's so simple,
        // that we can do it in one line.  the $account has the reset vector currently in the database.
        // therefore, we only need to see if the account's vector matches the $reset_vector argument
        // either a NotValid or a Valid payload as follows:

        return $account->get("reset_vector") != $reset_vector
            ? $this->payload->notValid(["account" => $account])
            : $this->payload->valid(["account" => $account]);
    }

    /**
     * @param $password
     * @param $confirmation
     * @return \Shadowlab\Interfaces\Domain\Payload
     */
    public function isPasswordValid($password, $confirmation)
    {
        // there are two things to check for here:  (1) that the password matches the confirmation and
        // (2) that the password meets the necessary criteria.  the first one is easy:

        if ($password == $confirmation) {

            // the criteria that our password much match are as follows:  it must have lower case letters,
            // capital letters, at least one number, and be at least ten characters long.  the following
            // regular expression matches each of those criteria.  thus, if you password matches the
            // expression, then we're good to go.

            $match = preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}$/', $password);
            if ($match) {
                $payload = $this->payload->valid([]);
            } else {
                $payload = $this->payload->notValid(["error" => "Your password did not meet all of the criteria."]);
            }
        } else {
            $payload = $this->payload->notValid(["error" => "Your password didn't match its confirmation."]);
        }

        return $payload;
    }

    /**
     * @param UserEntity $account
     * @param string $password
     * @return \Shadowlab\Interfaces\Domain\Payload
     * @throws EntityException
     */
    public function setPassword(UserEntity $account, $password)
    {
        // given an account and a password, we make sure the former uses the latter.  we can also
        // remove the database record of any reset vector because we both don't need it anymore and
        // we don't want to give people a way to potentially reset an account by guessing the reset
        // vector.

        $entity = $this->factory->newEntity([
            "user_id"      => $account->get("user_id"),
            "password"     => password_hash($password, PASSWORD_DEFAULT),
            "reset_vector" => "NULL"
        ]);

        $success = $this->gateway->update($entity);

        $payload = !$success
            ? $this->payload->notUpdated(["account" => $account])
            : $this->payload->updated(["account" => $account]);

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
