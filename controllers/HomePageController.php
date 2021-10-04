<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;

/**
 * Class HomePageController
 */
class HomePageController extends Controller
{

    public function getHomePage()
    {
        $params = [
            'name' => Application::$app->user ? Application::$app->user->getDisplayName() : '',
        ];

        return $this->render('home', $params);
    }
}
