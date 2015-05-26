<?php

namespace Girocheckout\Response;

class Response
{
    protected $_rawResponse;
    protected $_arrayResponse;
    protected $_success;
    protected $_errors = array();
    protected $_response;

    protected static $_factory = array(
        'TransactionSearch' => 'Girocheckout\\Response\\TransactionSearchResponse'
    );

    protected $_multiFieldMap = array(
        'ERRORS'  => array(
            'LONGMESSAGE',
            'SEVERITYCODE',
            'SHORTMESSAGE',
            'ERRORCODE'
        ),
        'FILTERS' => array(
            "FMFfilterID",
            "FMFfilterNAME"
        ),
        'ITEMS' => array(
            'NAME',
            'DESC',
            'AMT',
            'NUMBER',
            'QTY',
            'TAXAMT',
            'ITEMWEIGHTVALUE',
            'ITEMWEIGHTUNIT',
            'ITEMLENGTHVALUE',
            'ITEMLENGTHUNIT',
            'ITEMWIDTHVALUE',
            'ITEMWIDTHUNIT',
            'ITEMHEIGHTVALUE',
            'ITEMHEIGHTUNIT',
            'ITEMCATEGORY'
        )
    );

    public function __construct($response = "")
    {
        $this->_rawResponse  = $response;
        $parsedResponse      = $this->deformatNVP($response);
        $this->_arrayResponse = $parsedResponse;

        $this->checkSuccess($parsedResponse);
        if($this->isSuccess()) {
            $this->populate($parsedResponse);
        }
    }

    public static function factory($requestType, $response)
    {
        if(!empty(self::$_factory[$requestType])) {
            return new self::$_factory[$requestType]($response);
        }

        return new static($response);
    }

    /**
     * Template method for populating a response.  The default is to utilize the __call method to
     * access response values.  However there are cases where a Response class will need to post
     * format response information.
     *
     * @param $response array
     */
    protected function populate($response)
    {
        $this->_response = $response;
    }

    /**
     * Determine if the response was successful
     *
     * @param $parsedResponse
     */
    protected function checkSuccess($response)
    {
        if(!isset($response['responseEnvelope']['ack'])) {
            $this->_success = false;
            $this->addErrorMessage('ACK key not found in response.');
            return;
        } else if($response['responseEnvelope']['ack'] == "Success" || $response['responseEnvelope']['ack'] == "SuccessWithWarning") {
            $this->_success = true;
            return;
        }

        if(isset($response['ERRORS'])) {
            foreach($response['ERRORS'] as $error) {
                if(isset($error['LONGMESSAGE'])) {
                    $this->addErrorMessage($error['LONGMESSAGE']);
                }
            }
        } else {
            $this->addErrorMessage('Unknown error has occurred.');
        }

        $this->_success = false;
    }

    /**
     * Return the raw response
     *
     * @return string
     */
    public function getRawResponse()
    {
        return $this->_rawResponse;
    }

    /**
     * Return the raw response
     *
     * @return string
     */
    public function getArrayResponse()
    {
        return $this->_arrayResponse;
    }

    /**
     * Contains error messages if call is not successful
     *
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->_errors;
    }

    /**
     * Add an error message to the response
     *
     * @param $errorMessage
     * @return AbstractResponse
     */
    public function addErrorMessage($errorMessage)
    {
        array_push($this->_errors, $errorMessage);

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->_success;
    }

    /**
     * Parse the return string from Paypal into an Array.
     *
     * @param $nvpstr
     * @return array
     */
    private function deformatNVP($nvpstr)
    {

        $decodedText = html_entity_decode($nvpstr);
        $nvpstr = json_decode($decodedText, true);

        return $nvpstr;
    }

    /**
     * Parse out a key passed from deformatNVP.  This method returns an array with 3 values.
     *
     * Format: L_NAME0
     * 0 = number (0)
     * 1 = parent key (ITEMS)
     * 2 = formatted key (NAME)
     *
     * @param $key
     * @return array
     */
    protected function extractKeyValues($key) {
        $formattedKey = substr(str_replace("L_", "", $key), 0, -preg_match_all( "/[0-9]/", $key ));
        return array(
            substr($key, -preg_match_all( "/[0-9]/", $key )),
            $this->getMappedKeyName($formattedKey),
            $formattedKey
        );
    }

    /**
     * Take a field and attempt to map it to a particular key in the map array.
     *
     * @param $field
     * @return int|string
     */
    protected function getMappedKeyName($field)
    {
        $keyName = "OTHER";
        foreach($this->_multiFieldMap as $key => $value) {
            if(in_array($field, $value)) {
                $keyName = $key;
                break;
            }
        }

        return $keyName;
    }

    //map to properties

    /**
     * Generic accessor for response variables
     *
     * @param $method
     * @param $params
     * @return mixed null|string
     */
    public function __call($method, $params)
    {
        $prefix         = strtolower(substr($method, 0, 3));
        $propertyName   = substr($method, 3);
        if("get" != $prefix || false === isset($this->_response[strtoupper($propertyName)])) {
            return NULL;
        }

        return $this->_response[strtoupper($propertyName)];
    }
}
