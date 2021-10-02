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
    public Database $db;
    public Session $session;
    public static Application $app;
    public Controller $controller;

    /**
     * Application constructor
     */
    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this; // przypisanie instacji obiektu Application do stałej
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
    }

    /**
     * Uruchomienie aplikacji
     */
    public function run()
    {
        // wyświetlenie cokolwiek zostało zwrócone z routera
        echo $this->router->resolve();
    }

    /**
     * @return \app\core\Controller
     */
    public function getController(): \app\core\Controller
    {
        return $this->controller;
    }

    /**
     * @return \app\core\Controller
     */
    public function setController(\app\core\Controller $controller): void
    {
        $this->controller = $controller;
    }
}
