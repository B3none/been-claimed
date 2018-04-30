<?php

include("vendor/autoload.php");

$client = new \B3none\BeenClaimed\BeenClaimedClient();
$businessOne = $client->loadByMapsUrl('https://www.google.co.uk/maps/place/Hackwood+Farm/@52.9086998,-1.4657123,13z/data=!4m8!1m2!2m1!1sfarm!3m4!1s0x0:0xdf599c26a37caae1!8m2!3d52.9175521!4d-1.5751326');
echo "Business one: " . ($businessOne->hasBeenClaimed() ? "CLAIMED" : "NOT CLAIMED");

$businessTwo = $client->loadById('6247503322256067200');
echo "Business two: " . ($businessTwo->hasBeenClaimed() ? "CLAIMED" : "NOT CLAIMED");
