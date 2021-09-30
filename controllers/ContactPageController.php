<?php

namespace app\controllers;

use app\core\Application;

/**
 * Class ContactPageController
 */
class ContactPageController
{
    public static function getViewForm() {
        return Application::$app->router->renderView('contact');
    }

    public static function saveContactData() {
        return 'dsafsdfsdf';
    }
}