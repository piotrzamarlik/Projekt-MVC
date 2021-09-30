<?php

namespace app\controllers;


use app\core\Controller;
use app\core\Request;

/**
 * Class HomePageController
 */
class HomePageController extends Controller
{
    public function getHomePage() {
        $params = [
            'name' => 'Pioter'
        ];
        
        return $this->render('home', $params);
    }
}