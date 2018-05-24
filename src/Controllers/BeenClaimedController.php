<?php

namespace B3none\BeenClaimed\Controllers;

use B3none\BeenClaimed\Helpers\PageHelper;

class BeenClaimedController
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var PageHelper
     */
    protected $pageHelper;

    /**
     * BeenClaimedController constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->pageHelper = new PageHelper();
    }

    /**
     * Return whether the maps page has been claimed.
     *
     * @return bool
     */
    public function hasBeenClaimed() : bool
    {
        return !(new PageHelper())->detect($this->url);
    }

    /**
     * @param array $searchArray
     * @param bool $includeDefaults
     * @return bool
     */
    public function customDetection(array $searchArray, $includeDefaults = false) : bool
    {
        return (new PageHelper())->detect($this->url, $searchArray, $includeDefaults);
    }
}