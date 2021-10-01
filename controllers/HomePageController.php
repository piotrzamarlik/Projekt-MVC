<?php

namespace app\controllers;

use app\core\Controller;

/**
 * Class HomePageController
 */
class HomePageController extends Controller
{
    public function getHomePage()
    {
        $params = [
            'name' => 'Pioter',
        ];

        return $this->render('home', $params);
    }
}
