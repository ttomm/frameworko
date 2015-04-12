<?php

/**
 * Description of Autoloader
 *
 * @author Tomek
 */
class Autoloader 
{
    public static function load($className)
    {
        $relativeFilePath = DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        
        foreach (explode(';', get_include_path()) as $path) {
            //echo 'auto ' .$path . $relativeFilePath . '<br />';
            if (file_exists($path . $relativeFilePath)) {
                require_once $path . $relativeFilePath;                
                return;
            }
        }
        // @TODO ustawić inny typ Exception
        throw new Exception("File {$relativeFilePath} can not be loaded");
    }
}
