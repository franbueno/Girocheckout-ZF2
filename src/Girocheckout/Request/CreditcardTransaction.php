<?php
namespace Girocheckout\Request;

use Girocheckout\Request\AbstractRequest;

class CreditcardTransaction extends AbstractRequest
{
    const METHOD = "transaction/start";

    protected $method;
    protected $urlRedirect;
    protected $urlNotify;
    protected $amount;
    protected $merchantTxId;
    protected $currency;
    protected $purpose;
    protected $locale;
    protected $mobile;
    protected $pkn;
    protected $recurring;


    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->setMethod(self::METHOD);
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function setMerchantTxId($merchantTxId)
    {
        $this->merchantTxId = $merchantTxId;

        return $this;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;

        return $this;
    }

    public function setPkn($pkn)
    {
        $this->pkn = $pkn;

        return $this;
    }

    public function setRecurring($recurring)
    {
        $this->recurring = $recurring;

        return $this;
    }

    /**
     * (Required)
     * URL, where the notification has to be sent after payment
     *
     */
    public function setUrlNotify($urlNotify)
    {
        $this->urlNotify = $urlNotify;

        return $this;
    }

    /**
     * (Required)
     * URL, where the buyer has to be sent after payment
     *
     */
    public function setUrlRedirect($urlRedirect)
    {
        $this->urlRedirect = $urlRedirect;
    }


    
    public function getUrlNotify()
    {
        return $this->urlNotify;
    }

    public function getUrlRedirect()
    {
        return $this->urlRedirect;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getMerchantTxId()
    {
        return $this->merchantTxId;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getMobile()
    {
        return $this->locale;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getPurpose()
    {
        return $this->purpose;
    }

    public function getPkn()
    {
        return $this->pkn;
    }

    public function getRecurring()
    {
        return $this->recurring;
    }

    /**
     * Check the minimum required values for Giropay
     * Required:
     *  merchantTxId
     *  amount
     *  currency
     *  purpose
     *  urlRedirect
     *  urlNotify
     *
     * @return bool
     */
    public function isValid()
    {
        if(empty($this->merchantTxId) || empty($this->amount) || empty($this->currency) || empty($this->purpose) || empty($this->urlRedirect) || empty($this->urlNotify)) {
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