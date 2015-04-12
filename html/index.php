<?php
/** @TODO wydzielić do Routera i do Application->Run() 
*/

// set path to ROOT DIRECTORY
define('ROOT_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

echo ROOT_PATH;
echo '<pre>';
print_r($_SERVER);
echo '</pre>';
echo 'Include path<pre>';
set_include_path(implode(PATH_SEPARATOR, array( 
    ROOT_PATH . 'app' . DIRECTORY_SEPARATOR . 'controllers', 
    get_include_path()
)));
print_r(get_include_path());
echo '</pre>';

require_once './lib/Autoloader.php';
spl_autoload_register(array('Autoloader', 'load'));

$application = new lib\Application();
$application->run();

echo '<pre>';

$requestUriParts = array();
$requestUri = trim(filter_input(INPUT_SERVER, 'REQUEST_URI'), '\\/');

/*@TODO tutaj zamiast index można podstawić domyślny controller
 i domyślną akcję z configa */
if (empty($requestUri)) {
    $requestUriParts[] = 'Index';
    $requestUriParts[] = 'Index';    
}
else {
    $requestUriParts = explode('/', $requestUri);
    if (count($requestUriParts) == 1) {
        $requestUriParts[] = 'Index';
    }
}

print_r($requestUriParts);
echo '</pre>';

$controllersFolder = ROOT_PATH . 'app/controllers/';
$controllerFile = ucfirst($requestUriParts[0]) . 'Controller.php';

//if (file_exists($controllersFolder . $controllerFile) && is_readable($controllersFolder . $controllerFile)) {
//    include_once $controllerFile;
//} else {
//    $controllerFile = 'ErrorController.php';
//    include_once $controllerFile;
//}

$controllerName = substr($controllerFile, 0, -4);
$controllerObject = new $controllerName;

$actionName = ucfirst($requestUriParts[1]) . 'Action';

call_user_func(array($controllerObject, $actionName));
