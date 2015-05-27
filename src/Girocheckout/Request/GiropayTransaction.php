<?php
namespace Girocheckout\Request;

use Girocheckout\Request\AbstractRequest;

class GiropayTransaction extends AbstractRequest
{
    const METHOD = "/transaction/start";

    protected $method;
    protected $urlRedirect;
    protected $urlNotify;
    protected $amount;
    protected $merchantTxId;
    protected $currency;
    protected $purpose;
    protected $bic;
    protected $iban;
    protected $info1Label;
    protected $info1Text;
    protected $info2Label;
    protected $info2Text;
    protected $info3Label;
    protected $info3Text;
    protected $info4Label;
    protected $info4Text;
    protected $info5Label;
    protected $info5Text;


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

    public function setIban($iban)
    {
        $this->iban = $iban;

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

    public function setInfo2Label($info2Label)
    {
        $this->info2Label = $info2Label;

        return $this;
    }

    public function setInfo2Text($info2Text)
    {
        $this->info2Text = $info2Text;

        return $this;
    }

    public function setInfo3Label($info3Label)
    {
        $this->info3Label = $info3Label;

        return $this;
    }

    public function setInfo3Text($info3Text)
    {
        $this->info3Text = $info3Text;

        return $this;
    }

    public function setInfo4Label($info4Label)
    {
        $this->info4Label = $info4Label;

        return $this;
    }

    public function setInfo4Text($info4Text)
    {
        $this->info4Text = $info4Text;

        return $this;
    }

    public function setInfo5Label($info5Label)
    {
        $this->info5Label = $info5Label;

        return $this;
    }

    public function setInfo5Text($info5Text)
    {
        $this->info5Text = $info5Text;

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

    public function getInfo1Label()
    {
        return $this->info1Label;
    }

    public function getInfo1Text()
    {
        return $this->info1Label;
    }

    public function getInfo2Label()
    {
        return $this->info2Label;
    }

    public function getInfo2Text()
    {
        return $this->info2Label;
    }

    public function getInfo3Label()
    {
        return $this->info3Label;
    }

    public function getInfo3Text()
    {
        return $this->info3Label;
    }

    public function getInfo4Label()
    {
        return $this->info4Label;
    }

    public function getInfo4Text()
    {
        return $this->info4Label;
    }

    public function getInfo5Label()
    {
        return $this->info5Label;
    }

    public function getInfo5Text()
    {
        return $this->info5Label;
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

    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Check the minimum required values for Giropay
     * Required:
     *  merchantTxId
     *  amount
     *  currency
     *  purpose
     *  bic
     *  urlRedirect
     *  urlNotify
     *
     * @return bool
     */
    public function isValid()
    {
        if(empty($this->merchantTxId) || empty($this->amount) || empty($this->currency) || empty($this->purpose) || empty($this->bic) || empty($this->urlRedirect) || empty($this->urlNotify)) { 
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