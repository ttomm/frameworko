<?php
/** @TODO wydzielić do Routera i do Application->Run() 
*/

// set path to ROOT DIRECTORY
define('ROOT_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

echo 'ROOT_PATH: ' . ROOT_PATH;
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

$application = new \Lib\Application();
$application->run();
