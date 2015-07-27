<?php

namespace Lib;

/**
 * Description of Tool
 *
 * @author Tomek
 */
class Tool 
{
    static function dump($content, $label = null)
    {
        echo $label != null ? '<p>' . $label . '</p><pre>' : '<pre>';
        print_r($content);
        echo '</pre>';
    }
}
