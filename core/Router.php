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
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        // jeśli nie istnieje routing dla url
        if ($callback === false) {
            return "Nie znaleziono";
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        return call_user_func($callback);
        // echo '<pre>';
        // var_dump($callback);
        // echo '</pre>';
        // exit;

        // $this->routes['get'][$path] = $callback;
    }

    public function renderView($view) {
        include_once __DIR__ . "/../views/$view.php";
    }
}