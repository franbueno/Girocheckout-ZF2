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

    protected function getHMACMD5Hash($secret, $data) {
        return hash_hmac('MD5', $data, $secret);
    }
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

            $requestArray = (array) $request;
            unset($requestArray["\0*\0method"]);

            $requestArray = array_filter($requestArray);


            $requestConf['merchantId']     = $config->getMerchantId();
            $requestConf['projectId']      = $config->getProjectId();

            $params = array_merge($requestConf, $requestArray);

            if(false === $config->isValid()) {
                throw new \Exception("Configuration is not valid.");
            }

            if(is_null($client)) {
                throw new \Exception('Zend\Http\Client must be set and must be valid.');
            }

            if(false === $request->toArray()) {
                throw new \Exception(get_class($request) . " is invalid.");
            }

            $sortedValuesString             = implode('', array_values($params));
            $result_hash['hash']            = $this->getHMACMD5Hash($config->getHash(), $sortedValuesString);

            $result = array_merge($result_hash, $params);

            $client->setMethod('post');
            $client->setUri(new \Zend\Uri\Http($config->getEndpoint().$request->getMethod()));

            $client->setParameterPost($result);

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