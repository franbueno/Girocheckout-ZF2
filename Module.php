<?php

namespace Girocheckout;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Http\Client;

class Module implements AutoloaderProviderInterface
{
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Girocheckout\Service\Request' => function($sm) {
                    $config = $sm->get('application')->getConfig();
                    $apiConfig = isset($config['speck-girocheckout-api']) ? $config['speck-girocheckout-api'] : array();

                    $client = new \Zend\Http\Client;
                    $client->setAdapter(new \Zend\Http\Client\Adapter\Curl);

                    $request = new \Girocheckout\Service\Request;
                    $request->setClient($client);
                    $request->setConfig(
                        new \Girocheckout\Element\Config($apiConfig)
                    );

                    return $request;
                }
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
