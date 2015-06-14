<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lib;

/**
 * Description of BaseController
 *
 * @author Tomek
 */
abstract class BaseController 
{
    public function __construct() 
    {
        $this->init();
    }

    public function init() { }

}
