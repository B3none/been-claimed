<?php

namespace B3none\BeenClaimed\PageHelpers;

class MapsPageHelper implements PageHelper
{
    const MAPS_PAGE = "https://maps.google.com/?cid=";

    /**
     * @var string
     */
    protected $mapsPageBody;

    /**
     * @var array
     */
    protected $searchTerms = [
        "Claim this business"
    ];

    /**
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function detect(string $id) : bool
    {
        $this->mapsPageBody = file_get_contents(self::MAPS_PAGE . $id) ?? false;

        if (!$this->mapsPageBody) {
            throw new \Exception("Error: Failed to get contents for [". self::MAPS_PAGE . $id . "]");
        }

        return $this->wordSearch();
    }

    /**
     * @return bool
     */
    protected function wordSearch() : bool
    {
        if (!empty($this->searchTerms)) {
            foreach ($this->searchTerms as $searchTerm) {
                if (!!strpos($this->mapsPageBody, $searchTerm)) {
                    return true;
                };
            }
        }

        return false;
    }
}