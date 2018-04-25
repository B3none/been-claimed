<?php

namespace B3none\BeenClaimed;

use B3none\BeenClaimed\Controllers\BeenClaimedController;

class BeenClaimedClient
{
    const MAPS_URL = "https://maps.google.com/?cid=";

    /**
     * Load the BeenClaimedController with an ID.
     *
     * @param string $id
     * @return BeenClaimedController
     */
    public function loadById(string $id) : BeenClaimedController
    {
        return new BeenClaimedController(self::MAPS_URL . $id);
    }

    /**
     * Load BeenClaimedController with a Google Maps URL.
     *
     * @param string $url
     * @return BeenClaimedController
     */
    public function loadByMapsUrl(string $url) : BeenClaimedController
    {
        return new BeenClaimedController($url);
    }
}