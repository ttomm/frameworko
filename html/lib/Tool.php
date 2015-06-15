<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
