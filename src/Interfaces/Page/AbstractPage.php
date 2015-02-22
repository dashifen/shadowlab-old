<?php

namespace Shadowlab\Interfaces\Page;

use Shadowlab\Interfaces\Page\File;

/**
 * Class AbstractPage
 * @package Shadowlab\Interfaces\Page
 */
abstract class AbstractPage implements Page
{
    /**
     * @var string
     */
    protected $title   = '';
    /**
     * @var string
     */
    protected $heading = '';
    /**
     * @var array
     */
    protected $scripts = [];
    /**
     * @var array
     */
    protected $styles  = [];
    /**
     * @var File
     */
    protected $header  = '';
    /**
     * @var File
     */
    protected $footer  = '';
    /**
     * @var bool
     */
    protected $header_done = false;
    /**
     * @var bool
     */
    protected $footer_done = false;

    /**
     * @param $header
     * @param $footer
     */
    public function __construct(File $header, File $footer)
    {
        $this->setHeader($header);
        $this->setFooter($footer);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return array
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param string $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    /**
     * @return boolean
     */
    public function isHeaderDone()
    {
        return $this->header_done;
    }

    /**
     * @return boolean
     */
    public function isFooterDone()
    {
        return $this->footer_done;
    }





}