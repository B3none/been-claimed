<?php

namespace B3none\BeenClaimed\Tests;

use B3none\BeenClaimed\BeenClaimedClient;
use PHPUnit\Framework\TestCase;

class BeenClaimedClientTest extends TestCase
{
    public function test()
    {
        $bcc = BeenClaimedClient::create();
        $hbc = $bcc->hasBeenClaimed('6247503322256067200');
        $this->assertFalse($hbc);
    }
}