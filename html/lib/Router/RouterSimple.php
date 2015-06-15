<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lib\Router;
/**
 * Description of RouterSimple
 *
 * @author Tomek
 */
class RouterSimple implements IRouter
{
    private $_route = array();
    
    public function getRoute() 
    {
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

        $this->_route['controllerName'] = 'App\Controllers\\' . ucfirst($requestUriParts[0]) . 'Controller';
        //$controllerObject = new $controllerName;

        $this->_route['actionName'] = ucfirst($requestUriParts[1]) . 'Action';
        
        return $this->_route;
    }
}
