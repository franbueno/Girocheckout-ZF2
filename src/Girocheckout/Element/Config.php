<?php
namespace Girocheckout\Element;

class Config
{
    protected $merchantId;

    protected $projectId;

    protected $hash;

    protected $endpoint;

    protected $redirect;


    protected $validElements = array('merchantId', 'projectId', 'hash', 'endpoint', 'redirect');

    public function __construct($options)
    {
        foreach($this->validElements as $key) {
            if(isset($options[$key])) {
                $this->$key = $options[$key];
            }
        }
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    public function getRedirect()
    {
        return $this->redirect;
    }

    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function isValid()
    {
        foreach($this->validElements as $element) {
            if(is_null($this->$element)) {
                return false;
            }
        }

        return true;
    }

    public function __toString()
    {
        return "&PWD=". urlencode($this->projectId)
                . "&USER=". urlencode($this->merchantId)
                . "&SIGNATURE=". urlencode($this->hash);
    }
}