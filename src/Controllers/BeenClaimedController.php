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
     * BeenClaimedController constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
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
}