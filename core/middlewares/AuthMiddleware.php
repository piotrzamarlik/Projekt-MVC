<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\middlewares\BaseMiddleware;
use app\core\exception\ForbiddenException;

/**
 * Class BaseMiddleware
 */
class AuthMiddleware extends BaseMiddleware
{
    public $actions;

    public function __constructor(array $actions = [])
    {
        echo '<pre>';
        var_dump('AuthMiddleware');
        echo '</pre>';
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}