<?php

namespace B3none\BeenClaimed\PageHelpers;

interface PageHelper
{
    public function detect(string $id) : bool;
}