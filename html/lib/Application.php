<?php

namespace lib;

/**
 * Starts application
 *
 * @author Tomek
 * 
 * wstępną konfigurację przenieść do bootstrapa
 */
class Application 
{
    private $_router;
    
    private $_url;
    
    private $_config;
    
    public function __construct()
    {
        // popróbować z url'em
        $this->_url = new \Vendor\Purl\Url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        
        $this->_router = new \Lib\Router\RouterSimple();
        
        $this->_config = include_once 'config/app.php';
        
        
    }
    
    
    public function run()
    {
        // get action to run
        $routeParams = $this->_router->getRoute();  //<- zwraca tablicę ('action' => $action, 'controller' => $controller
        $controllerObject = new $routeParams['controllerName']();
        echo '<pre>';
        print_r($routeParams);
        echo '</pre>';
        call_user_func(array($controllerObject, new $routeParams['actionName']));
    }
}
