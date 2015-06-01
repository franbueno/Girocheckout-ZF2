<?php
namespace Girocheckout\Request;

use Girocheckout\Request\AbstractRequest;

class GiropayBankstatus extends AbstractRequest
{
    const METHOD = "/giropay/bankstatus";

    protected $method;
    public $bic;


    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->setMethod(self::METHOD);
    }

    public function setBic($bic)
    {
        $this->bic = $bic;

        return $this;
    }

    public function getBic()
    {
        return $this->bic;
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
        if(empty($this->bic)) {
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