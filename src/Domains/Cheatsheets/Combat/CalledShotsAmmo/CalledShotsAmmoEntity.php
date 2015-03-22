<?php

namespace Shadowlab\Domains\Cheatsheets\Combat\CalledShotsAmmo;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class CalledShotsAmmoEntity extends AbstractEntity
{
    protected $enhancement_id;
    protected $enhancement;
    protected $called_shot;
    protected $description;
    protected $ammo_type;
    protected $modifier;
    protected $max_dv;
    protected $effect;
    protected $book_id;
    protected $book;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
