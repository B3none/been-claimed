<?php

namespace B3none\BeenClaimed\PageHelpers;

class BusinessPageHelper implements PageHelper
{
    const BUSINESS_PAGE = "https://business.google.com/add/confirm/c/";

    protected $businessPageBody;

    protected $searchTerms = [];

    /**
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function detect(string $id) : bool
    {
        $this->businessPageBody = file_get_contents(self::BUSINESS_PAGE . $id) ?? false;

        if (!$this->businessPageBody) {
            throw new \Exception("Error: Failed to get contents for [". self::BUSINESS_PAGE . $id . "]");
        }

        return $this->wordSearch();
    }

    /**
     * @return bool
     */
    protected function wordSearch()
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