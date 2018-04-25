# BeenClaimed
Detect whether a Google Maps listing has been claimed.

# Example usage
```php
$beenClaimedClient = new BeenClaimedClient();
$claimedSite = $beenClaimedClient->loadById((string)$id);
$claimedSite->hasBeenClaimed();

$unclaimedSite = $beenClaimedClient->loadByMapsUrl((string)$mapsUrl);
$unclaimedSite->hasBeenClaimed();
```