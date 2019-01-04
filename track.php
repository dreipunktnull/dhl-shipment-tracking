<?php

namespace DPN\DHLShipmentTracking;

require_once('vendor/autoload.php');

// sandbox: username (entwickler.dhl.de)
// production: app name (entwickler.dhl.de)
$cig_user = '';

// sandbox: password (entwickler.dhl.de)
// production: app token (entwickler.dhl.de)
$cig_password = '';

// sandbox: zt12345
// production: user zt...
$tnt_user = 'zt12345';

// sandbox: geheim
// production: user password
$tnt_password = 'geheim';

// creates a new Credentials object
// endpoint: ENDPOINT_SANDBOX / ENDPOINT_PRODUCTION
// api: https://entwickler.dhl.de/group/ep/wsapis/sendungsverfolgung
$credentials = new Credentials($cig_user, $cig_password, Credentials::ENDPOINT_SANDBOX, $tnt_user, $tnt_password);

$api = new ShipmentTracking($credentials);

// sandbox piece nr: 2200340434161094015902
$pieceNumber = '2200340434161094015902';

$result = $api->getDetails($pieceNumber, RequestBuilder::LANG_DE);
print_r($result);

$result = $api->getDetailsAndEvents($pieceNumber, RequestBuilder::LANG_DE);
print_r($result);

$result = $api->getSignature($pieceNumber, RequestBuilder::LANG_DE);
print_r($result);

// only works in production mode
$result = $api->getPublicDetails($pieceNumber, RequestBuilder::LANG_EN);
print_r($result);
