<?php

namespace DPN\DHLShipmentTracking;

class ShipmentTracking
{
    const OPERATION_GET_PIECE = 'd-get-piece';
    const OPERATION_GET_PIECE_DETAIL = 'd-get-piece-detail';
    const OPERATION_STATUS_PUBLIC = 'get-status-for-public-user';

    /**
     * @var Credentials
     */
    protected $credentials;

    /**
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @param string $pieceNumber
     * @param string $language
     * @return bool|string
     */
    public function getPiece(string $pieceNumber, string $language = RequestBuilder::LANG_EN)
    {
        return $this->call(static::OPERATION_GET_PIECE, $pieceNumber, $language);
    }

    /**
     * @param string $pieceNumber
     * @param string $language
     * @return bool|string
     */
    public function getPieceDetail(string $pieceNumber, string $language = RequestBuilder::LANG_EN)
    {
        return $this->call(static::OPERATION_GET_PIECE_DETAIL, $pieceNumber, $language);
    }

    /**
     * @param string $pieceNumber
     * @param string $language
     * @return bool|string
     */
    public function getPiecePublic(string $pieceNumber, string $language = RequestBuilder::LANG_EN)
    {
        return $this->callPublic(static::OPERATION_STATUS_PUBLIC, $pieceNumber, $language);
    }

    /**
     * @param string $operation
     * @param string $pieceCode
     * @param string $language
     * @return bool|string
     */
    private function call($operation, $pieceCode, string $language = RequestBuilder::LANG_EN)
    {
        $request = RequestBuilder::createRequestXML($operation, $this->credentials->tnt_user, $this->credentials->tnt_password, $language, $pieceCode);
        $context = stream_context_create(
            array(
                'http' => array(
                    'header' => 'Authorization: Basic ' . base64_encode($this->credentials->cig_user . ':' . $this->credentials->cig_password) . "\r\n" .
                        "Content-type: text/xml \r\n"
                )
            )
        );

        $response = file_get_contents($this->credentials->cig_endpoint . '?xml=' . urlencode($request), false, $context);

        return $this->xmlpp($response);
    }

    /**
     * @param string $operation
     * @param string $pieceCode
     * @param string $language
     * @return bool|string
     */
    private function callPublic($operation, $pieceCode, string $language = RequestBuilder::LANG_EN)
    {
        $request = RequestBuilder::createRequestPublicXML($operation, $this->credentials->tnt_user, $this->credentials->tnt_password, $language, $pieceCode);
        $context = stream_context_create(
            array(
                'http' => array(
                    'header' => 'Authorization: Basic ' . base64_encode($this->credentials->cig_user . ':' . $this->credentials->cig_password) . "\r\n" .
                        "Content-type: text/xml \r\n"
                )
            )
        );

        $response = file_get_contents($this->credentials->cig_endpoint . '?xml=' . urlencode($request), false, $context);

        return $this->xmlpp($response);
    }

    public function xmlpp($xml, $html_output = false)
    {
        $xml_obj = new \SimpleXMLElement($xml);
        $level = 4;
        $indent = 0; // current indentation level
        $pretty = array();

        // get an array containing each XML element
        $xml = explode("\n", preg_replace('/>\s*</', ">\n<", $xml_obj->asXML()));

        // shift off opening XML tag if present
        if (count($xml) && preg_match('/^<\?\s*xml/', $xml[0])) {
            $pretty[] = array_shift($xml);
        }

        foreach ($xml as $el) {
            if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {
                // opening tag, increase indent
                $pretty[] = str_repeat(' ', $indent) . $el;
                $indent += $level;
            } else {
                if (preg_match('/^<\/.+>$/', $el)) {
                    $indent -= $level;  // closing tag, decrease indent
                }
                if ($indent < 0) {
                    $indent += $level;
                }
                $pretty[] = str_repeat(' ', $indent) . $el;
            }
        }
        $xml = implode("\n", $pretty);
        return $html_output ? htmlentities($xml) : $xml;
    }
}
