<?php

namespace B3none\BeenClaimed\Helpers;

use B3none\BeenClaimed\Scraper\ScraperClient;

class PageHelper
{
    // One hour.
    const STORE_TIME = (60 * 60);

    /**
     * @var array
     */
    protected $bodies;

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
     * @param array $customSearchTerms
     * @param bool $includeDefaults
     * @return bool
     */
    public function detect(string $url, array $customSearchTerms = [], bool $includeDefaults = false) : bool
    {
        if (sizeof($customSearchTerms)) {
            if ($includeDefaults) {
                $this->searchTerms = array_merge($this->searchTerms, $customSearchTerms);
            } else {
                $this->searchTerms = $customSearchTerms;
            }
        }

        if (sizeof($this->searchTerms)) {
            if (!$this->bodies[$url] || $this->bodies[$url]['expire'] < time()) {
                $scraper = new ScraperClient($url);
                $this->bodies[$url] = [
                    'body' => $scraper->getHTML(),
                    'expire' => time() + self::STORE_TIME
                ];
            }
        } else {
            return false;
        }

        return $this->wordSearch($url);
    }

    /**
     * @param string $url
     * @return bool
     */
    protected function wordSearch(string $url) : bool
    {
        foreach ($this->searchTerms as $searchTerm) {
            if (!!strpos($this->bodies[$url], $searchTerm)) {
                return true;
            };
        }

        return false;
    }
}