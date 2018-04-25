<?php

namespace B3none\BeenClaimed\Tests;

use B3none\BeenClaimed\BeenClaimedClient;
use PHPUnit\Framework\TestCase;

class BeenClaimedClientTest extends TestCase
{
    public function test()
    {
        $bcc = new BeenClaimedClient();
        $claimedSite = $bcc->loadById('6247503322256067200');
        $this->assertTrue($claimedSite->hasBeenClaimed());

        $unclaimedSite = $bcc->loadByMapsUrl('https://www.google.co.uk/maps/place/Hackwood+Farm/@52.9086998,-1.4657123,13z/data=!4m8!1m2!2m1!1sfarm!3m4!1s0x0:0xdf599c26a37caae1!8m2!3d52.9175521!4d-1.5751326');
        $this->assertFalse($unclaimedSite->hasBeenClaimed());
    }
}