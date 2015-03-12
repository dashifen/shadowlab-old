<?php

namespace Shadowlab\Domains\Cheatsheets\Other\Qualities;

use Shadowlab\Interfaces\Domain\AbstractEntity;

class QualitiesEntity extends AbstractEntity
{
    protected $quality;
    protected $quality_id;
    protected $description;
    protected $max_rating;
    protected $rated_cost;
    protected $specific_cost;
    protected $metagenetic;
    protected $freakish;
    protected $book_id;
    protected $abbr;
    protected $page;

    public function __construct(array $data = [])
    {
        $this->setAll($data);
    }
}
