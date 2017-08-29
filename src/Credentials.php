<?php

namespace DPN\DHLShipmentTracking;

class Credentials
{
    const ENDPOINT_SANDBOX = 'https://cig.dhl.de/services/sandbox/rest/sendungsverfolgung';

    const ENDPOINT_PRODUCTION = 'https://cig.dhl.de/services/production/rest/sendungsverfolgung';

    /**
     * @var string
     */
    public $cig_user;

    /**
     * @var string
     */
    public $cig_password;

    /**
     * @var string
     */
    public $cig_endpoint;
    /**
     * @var string
     */
    public $tnt_user;
    /**
     * @var string
     */
    public $tnt_password;

    /**
     * @param string $cig_user
     * @param string $cig_password
     * @param string $cig_endpoint
     * @param string $tnt_user
     * @param string $tnt_password
     */
    public function __construct($cig_user, $cig_password, $cig_endpoint = self::ENDPOINT_SANDBOX, $tnt_user, $tnt_password)
    {
        $this->cig_user = $cig_user;
        $this->cig_password = $cig_password;
        $this->cig_endpoint = $cig_endpoint;
        $this->tnt_user = $tnt_user;
        $this->tnt_password = $tnt_password;
    }
}
