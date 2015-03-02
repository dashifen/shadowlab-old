<?php

namespace Shadowlab\Domains\User;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class UserEntity extends AbstractEntity
{
    protected $user_id;
    protected $username;
    protected $password;
    protected $reset_vector;
    protected $email_address;

    public function __construct($data)
    {
        $this->setAll($data);
    }
}