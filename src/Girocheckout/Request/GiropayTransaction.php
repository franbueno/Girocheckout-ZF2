<?php
namespace Girocheckout\Request;

use Girocheckout\Request\AbstractRequest;

class Giropay extends AbstractRequest
{
    const METHOD = "Giropay";

    protected $method;
    protected $urlRedirect;
    protected $urlNotify;
    protected $amount;
    protected $merchantTxId;
    protected $info1Label;
    protected $info1Text;
    protected $currency;
    protected $purpose;
    protected $bic;
    protected $requestURL = "https://payment.girosolution.de/girocheckout/api/v2/transaction/start";


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

    public function setInfo1Label($info1Label)
    {
        $this->info1Label = $info1Label;

        return $this;
    }

    public function setInfo1Text($info1Text)
    {
        $this->info1Text = $info1Text;

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

    public function setBic($bic)
    {
        $this->bic = $bic;

        return $this;
    }

    /**
     * (Required)
     * URL to which the customer is returned if he does not approve the use of
     * PayPal to pay you.
     * NOTE: PayPal recommends that the value be the original page on which the
     * customer chose to pay with PayPal or establish a billing agreement.
     * Character length and limitations: 2048 characters
     */
    public function setUrlNotify($urlNotify)
    {
        $this->urlNotify = $urlNotify;

        return $this;
    }

    /**
     * (Required)
     * URL to which the customerís browser is returned after choosing to pay
     * with PayPal.
     * NOTE: PayPal recommends that the value be the final review page on which the
     * customer confirms the order and payment or billing agreement.
     *
     * Character length and limitations: 2048 characters
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

    public function getInfo1Label()
    {
        return $this->info1Label;
    }

    public function getInfo1Text()
    {
        return $this->info1Label;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getPurpose()
    {
        return $this->purpose;
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
        if(empty($this->urlRedirect) || empty($this->urlNotify)) {
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