<?php

namespace B3none\BeenClaimed\PageHelpers;

use B3none\BeenClaimed\Scraper\ScraperClient;

class MapsPageHelper implements PageHelper
{
    const MAPS_PAGE = "https://maps.google.com/?cid=";

    /**
     * @var string
     */
    protected $mapsPageBody;

    /**
     * This is what we search the HTML output for.
     *
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
        $scraper = new ScraperClient(self::MAPS_PAGE . $id);
        $this->mapsPageBody = $scraper->getHTML();

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