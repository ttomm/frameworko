<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

/**
 * Description of IndexController
 *
 * @author Tomek
 */
class IndexController extends \Lib\BaseController
{
    public function init()
    {
        echo "Funkcja init<br/>";
    }
    public function IndexAction()
    {
        echo 'Uruchomiony Index controleer i akcja Index';
    }
}