<?php
namespace Girocheckout\Request;

use Girocheckout\Element\AbstractElement;

abstract class AbstractRequest extends AbstractElement
{
    protected $method;

    abstract public function isValid();

    /**
     * (Required)
     *
     * @param $method
     * @return AbstractRequest
     */
    protected function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Return formatted NVP string
     *
     * @return string
     */
    public function __toString()
    {
        $data   = $this->toArray();
        $query  = array();

        foreach ( $data as $key => $value) {
            $query[] = strtoupper($key) . '='. urlencode($value);
        }

        return '&' . implode('&', $query);
    }
}