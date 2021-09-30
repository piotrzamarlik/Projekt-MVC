<?php

namespace app\core;

/**
 * Class Controller
 */
class Controller
{
    public function setLayout($layout)
    {

    }

    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }
}