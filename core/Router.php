<?php

namespace app\core;

use app\core\exception\NotFoundException;

/**
 * Class Router
 */
class Router
{
    public Request $request;
    public Response $response;
    // tablica z routingiem
    protected $routes = [];

    /**
     * Router konstruktor
     *
     * @param app\core\Request $request
     * @param app\core\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    /**
     * Get method - dodanie to routingu ścieżki i akcji zwrotnej
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Post method - dodanie to routingu ścieżki i akcji zwrotnej
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        // pobranie ścieżki z requesta
        $path = $this->request->getPath();
        // pobranie metody z requesta - GET, POST, PUT, DELETE
        $method = $this->request->method();
        // pobranie akcji na dany routing
        $callback = $this->routes[$method][$path] ?? false;
        // jeśli nie istnieje routing dla url
        if ($callback === false) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if (is_array($callback)) {
            // $controler jest instancją app\controller\Controller
            // wstawienie instacji  obiektu na indeks 0 w callback z np. ContactPageController::class
            // bez tego zwracany jest string i w metodzie render w kontorlerze $this jest stringiem a nie obiektem
            $controller = new $callback[0]();
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            // ustawienie akcji dla middleware'a
        // echo '<pre>';
        // var_dump($controller);
        // echo '</pre>';

            foreach ($controller->getMiddlewares() as $middleware) {
        //         echo '<pre>';
        // var_dump($middleware);
        // echo '</pre>';
                $middleware->execute();
            }
            $callback[0] = $controller;
        }

        // przesłanie callback i dodatkowego parametru $requesta, tak aby był dostępny w kontrolerze
        return call_user_func($callback, $this->request, $this->response);
    }
}
