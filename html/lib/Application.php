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
        
        $this->_config = include_once 'config/app.php';
        
        
    }
    
    
    public function run()
    {
        // get action to run
        // $this->_router->getRoute();  <- zwraca tablicę ('action' => $action, 'controller' => $controller
        $requestUriParts = array();
        $requestUri = trim(filter_input(INPUT_SERVER, 'REQUEST_URI'), '\\/');

        if (empty($requestUri)) {
            $requestUriParts[] = isset($this->_config['router']['defaultController']) ? $this->_config['router']['defaultController'] : 'Index';
            $requestUriParts[] = isset($this->_config['router']['defaultAction']) ? $this->_config['router']['defaultAction'] : 'Index';    
        }
        else {
            $requestUriParts = explode('/', $requestUri);
            if (count($requestUriParts) == 1) {
                $requestUriParts[] = 'Index';
            }
        }

        $controllersFolder = ROOT_PATH . 'app/controllers/';
        $controllerFile = ucfirst($requestUriParts[0]) . 'Controller.php';

        //if (file_exists($controllersFolder . $controllerFile) && is_readable($controllersFolder . $controllerFile)) {
        //    include_once $controllerFile;
        //} else {
        //    $controllerFile = 'ErrorController.php';
        //    include_once $controllerFile;
        //}

        $controllerName = 'App\Controllers\\' . ucfirst($requestUriParts[0]) . 'Controller';
        $controllerObject = new $controllerName;

        $actionName = ucfirst($requestUriParts[1]) . 'Action';

        call_user_func(array($controllerObject, $actionName));
    }
}
