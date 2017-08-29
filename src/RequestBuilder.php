<?php

namespace DPN\DHLShipmentTracking;

class RequestBuilder
{
    const ATTR_ROOT = 'data';
    const ATTR_PASSWORD = 'password';
    const ATTR_APPNAME = 'appname';
    const ATTR_REQUEST = 'request';
    const ATTR_LANG = 'language-code';
    const ATTR_PIECE_CODE = 'piece-code';

    const LANG_DE = 'de';
    const LANG_EN = 'en';

    /**
     * Creates the request data for a XML Request.
     *
     * @param string $operation
     * @param string $appname
     * @param string $password
     * @param string $language
     * @param string $pieceCode
     * @return string
     */
    public static function createRequestXML(string $operation, string $appname, string $password, string $language, string $pieceCode): string
    {
        $xml = new \SimpleXMLElement('<' . static::ATTR_ROOT . '/>');
        $xml->addAttribute(static::ATTR_APPNAME, $appname);
        $xml->addAttribute(static::ATTR_PASSWORD, $password);
        $xml->addAttribute(static::ATTR_REQUEST, $operation);
        $xml->addAttribute(static::ATTR_LANG, $language);
        $xml->addAttribute(static::ATTR_PIECE_CODE, $pieceCode);

        return $xml->asXML();
    }

    /**
     * Creates the request data for a "Public XML" Request.
     *
     * @param string $operation
     * @param string $appname
     * @param string $password
     * @param string $language
     * @param $pieceCode
     * @return string
     */
    public static function createRequestPublicXML(string $operation, string $appname, string $password, string $language, $pieceCode): string
    {
        $xml = new \SimpleXMLElement('<' . static::ATTR_ROOT . '/>');
        $xml->addAttribute(static::ATTR_APPNAME, $appname);
        $xml->addAttribute(static::ATTR_PASSWORD, $password);
        $xml->addAttribute(static::ATTR_REQUEST, $operation);
        $xml->addAttribute(static::ATTR_LANG, $language);
        $xml->addChild(static::ATTR_ROOT)->addAttribute(static::ATTR_PIECE_CODE, $pieceCode);

        return $xml->asXML();
    }
}
