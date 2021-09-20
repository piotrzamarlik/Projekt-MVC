<?php

namespace app\core;

/**
 * Class Application
 */
class Application
{
    public Router $router;
    /**
     * Application constructor
     */
    public function __construct()
    {
        $this->router = new Router();
    }
}