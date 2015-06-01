<?php
namespace Girocheckout\Request;

use Girocheckout\Request\AbstractRequest;

class GiropayTransactionDetails extends AbstractRequest
{
    const METHOD = "/transaction/status";

    protected $method;
    public $reference;


    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->setMethod(self::METHOD);
    }

    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Check the minimum required values for Preapproval
     * Required:
     *  AMT
     *  RETURNURL
     *  CANCELURL
     *
     * @return bool
     */
    public function isValid()
    {
        if(empty($this->reference)) {
            return false;
        }

        $valid = true;

        return $valid;
    }

    public function toArray()
    {
        $data = parent::toArray();

        return $data;
    }
}