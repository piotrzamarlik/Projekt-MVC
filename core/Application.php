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

    /**
     * Application constructor
     */
    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    /**
     * 
     */
    public function run()
    {
        // wyświetlenie cokolwiek zostało zwrócone z routera
        echo $this->router->resolve();
    }
}