<?php

namespace app\controllers;

use app\core\Application;

/**
 * Class HomePageController
 */
class HomePageController
{
    public static function getHomePage() {
        $params = [
            'name' => 'Pioter'
        ];
        return Application::$app->router->renderView('home', $params);
    }
}