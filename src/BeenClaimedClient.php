<?php

namespace B3none\BeenClaimed;

use B3none\BeenClaimed\PageHelpers\BusinessPageHelper;
use B3none\BeenClaimed\PageHelpers\MapsPageHelper;

class BeenClaimedClient
{
    /**
     * @var BusinessPageHelper
     */
    protected $businessPageHelper;

    /**
     * @var MapsPageHelper
     */
    protected $mapsPageHelper;

    public static function create()
    {
        return new self(new BusinessPageHelper(), new MapsPageHelper());
    }

    public function __construct(BusinessPageHelper $businessPageHelper, MapsPageHelper $mapsPageHelper)
    {
        $this->businessPageHelper = $businessPageHelper;
        $this->mapsPageHelper = $mapsPageHelper;
    }

    /**
     * Return whether the page has been claimed.
     *
     * @param string $id
     * @return bool
     */
    public function hasBeenClaimed(string $id) : bool
    {
        /**
         * TODO: Scrape google maps.
         * TODO: Scrape my business.
         */
        try {
            return ($this->businessPageHelper->detect($id) || $this->mapsPageHelper->detect($id));
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}