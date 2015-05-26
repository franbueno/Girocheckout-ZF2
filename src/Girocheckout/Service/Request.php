<?php
namespace Girocheckout\Service;

use Girocheckout\Request\AbstractRequest;
use Girocheckout\Response\Response;

class Request
{
    /*
     * @var \Zend\Http\Client
     */
    protected $client;

    /*
     * @var array
     */
    protected $config;

    /**
     * Make the paypal request and return a Response object
     *
     * @param AbstractRequest $model
     * @return Response
     * @throws Exception
     */
    public function send(AbstractRequest $request)
    {
        try {

            $client = $this->client;
            $config = $this->config;

            if(false === $config->isValid()) {
                throw new \Exception("Configuration is not valid.");
            }

            if(is_null($client)) {
                throw new \Exception('Zend\Http\Client must be set and must be valid.');
            }

            if(false === $request->isValid()) {
                throw new \Exception(get_class($request) . " is invalid.");
            }

            $jar = json_encode((array) $request);

            $find = array("*","\u0000");

            $jar = str_replace($find, '', $jar);

            $client->setMethod('post');
            $client->setUri(new \Zend\Uri\Http($config->getEndpoint().$request->getMethod()));
            $client->setRawBody($jar);

            $httpResponse = $client->send();

            $response = Response::factory($request->getMethod(), $httpResponse->getBody());

        } catch(\Exception $e) {

            $response = new Response();
            $response->addErrorMessage($e->getMessage());
        }

        return $response;
    }

    public function setClient(\Zend\Http\Client $client)
    {
        $this->client = $client;
    }

    public function setConfig(\Girocheckout\Element\Config $config)
    {
        $this->config = $config;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getConfig()
    {
        return $this->config;
    }
}