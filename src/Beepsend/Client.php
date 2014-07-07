<?php

namespace Beepsend;

use Beepsend\Request;

use Beepsend\Exception\NotFoundResource;

class Client {
    
    /**
     * Version of Beepsend PHP helper
     */
    public $version = '0.1';
    
    /**
     * Beepsend request handler
     * @var Beepsend\Request;
     */
    private $request;
    
    /**
     * Init beepsend client
     * @param string $token User or Connection token to work with
     */
    public function __construct($token)
    {
        $this->request = new Request($token);
    }
    
    /**
     * Load resource that user will work with
     * @param string $resource Name of resource that we wan't to load
     * @return Object
     */
    public function __get($resource)
    {
        return $this->loadResource($resource);
    }
    
    /**
     * Try to load resource
     * @param string $resource Resource name
     * @return Object Resource
     * @throws NotFoundResource
     */
    private function loadResource($resource)
    {
        $resourceName = ucfirst($resource);
        if (file_exists(__DIR__ . '/Resource/' . $resourceName . '.php')) {
            $loadResource = "Beepsend\Resource\\{$resourceName}";
            return new $loadResource($this->request);
        }
        
        throw new NotFoundResource('Resource ' . $resourceName . ' can not be found!');
    }
}