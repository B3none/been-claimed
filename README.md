# BeenClaimed
Detect whether a Google Maps listing has been claimed.

# Author
[B3none](https://b3none.co.uk/) - Developer / Maintainer

# Example usage
```php
$beenClaimedClient = new BeenClaimedClient();
$claimedSite = $beenClaimedClient->loadById((string)$id);
$claimedSite->hasBeenClaimed();

$unclaimedSite = $beenClaimedClient->loadByMapsUrl((string)$mapsUrl);
$unclaimedSite->hasBeenClaimed();
```
