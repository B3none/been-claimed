<?php

namespace B3none\BeenClaimed\PageHelpers;

use B3none\BeenClaimed\Scraper\ScraperClient;

class BusinessPageHelper implements PageHelper
{
    const BUSINESS_PAGE = "https://business.google.com/add/confirm/c/";

    /**
     * @var string
     */
    protected $businessPageBody;

    /**
     * TODO: Add some search terms for the business page...
     *
     * @var array
     */
    protected $searchTerms = [];

    /**
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function detect(string $id) : bool
    {
        $scraper = new ScraperClient(self::BUSINESS_PAGE . $id);
        $this->businessPageBody = $scraper->getHTML();

        return $this->wordSearch();
    }

    /**
     * @return bool
     */
    protected function wordSearch() : bool
    {
        if (!empty($this->searchTerms)) {
            foreach ($this->searchTerms as $searchTerm) {
                if (!!strpos($this->businessPageBody, $searchTerm)) {
                    return true;
                };
            }
        }

        return false;
    }
}