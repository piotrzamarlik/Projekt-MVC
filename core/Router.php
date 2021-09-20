<?php

namespace app\core;

/**
 * Class Router
 */
class Router
{
    public Request $request;
    protected array $routes = [];

    public function __construct(\app\core\Request $request)
    {
        $this->request = $request;
    }
    /**
     * Get method
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $this->request->getPath();
        // $this->routes['get'][$path] = $callback;
    }
}