<?php

namespace app\core;

/**
 * Class Application
 */
class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;

    /**
     * Application constructor
     */
    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this; // przypisanie instacji obiektu Application do stałej
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    /**
     * Uruchomienie aplikacji
     */
    public function run()
    {
        // wyświetlenie cokolwiek zostało zwrócone z routera
        echo $this->router->resolve();
    }
}