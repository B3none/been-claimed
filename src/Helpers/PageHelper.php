<?php

namespace B3none\BeenClaimed\Helpers;

use B3none\BeenClaimed\Scraper\ScraperClient;

class PageHelper
{
    /**
     * @var string
     */
    protected $body;

    /**
     * This is what we search the HTML output for.
     *
     * @var array
     */
    protected $searchTerms = [
        "Claim this business"
    ];

    /**
     * @param string $url
     * @return bool
     */
    public function detect(string $url) : bool
    {
        if (sizeof($this->searchTerms)) {
            $scraper = new ScraperClient($url);
            $this->body = $scraper->getHTML();
        } else {
            return false;
        }

        return $this->wordSearch();
    }

    /**
     * @return bool
     */
    protected function wordSearch() : bool
    {
        foreach ($this->searchTerms as $searchTerm) {
            if (!!strpos($this->body, $searchTerm)) {
                return true;
            };
        }

        return false;
    }
}