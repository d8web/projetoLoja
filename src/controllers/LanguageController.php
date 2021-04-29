<?php
namespace src\controllers;

use core\Controller;
use core\Language;

class LanguageController extends Controller
{
    public function set($atts)
    {
    	$_SESSION['lang'] = $atts['lang'];
    	$this->redirect('/');
    }

}