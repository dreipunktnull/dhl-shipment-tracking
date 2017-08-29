# DHL Shipment Tracking for PHP

## Installation

```
composer require dreipunktnull/dhl-shipment-tracking
```

## Usage

```php
/**
 * Creates a new Credentials object.
 *
 * Uses the sandbox as default API where
 *   - $tnt_user = track n trace user
 *   - $tnt_password = track n trace password
 */

$cig_user = ''; // your developer id
$cig_password = ''; // developer password

$tnt_user = 'dhl_entwicklerportal';
$tnt_password = 'Dhl_123!';

$credentials = new Credentials($cig_user, $cig_password, Credentials::ENDPOINT_SANDBOX, $tnt_user, $tnt_password);

$api = new ShipmentTracking($credentials);

$pieceNumber = '22....';
$result = $api->getPiece($pieceNumber, RequestBuilder::LANG_EN);

$result = $api->getPieceDetail($pieceNumber, RequestBuilder::LANG_EN);

$result = $api->getPiecePublic($pieceNumber, RequestBuilder::LANG_EN);
```

## License

MIT
