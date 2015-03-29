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
    protected $last_update;
    protected $created_on;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
