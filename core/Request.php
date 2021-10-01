<?php

namespace app\core;

/**
 * Class Application
 */
class Request
{
    public Router $router;

    /**
     * Get path
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        // jeśli nie wystąpił znak '?' w ścieżce url
        if ($position === false) {
            return $path;
        }
        // pobranie url od początki do wystapienia znaku '?'
        return substr($path, 0, $position);
    }

    /**
     * Metoda do pobrania typu żądania - GET, POST, PUT, DELETE
     */
    public function method()
    {
        // zwrócenie metody, jaka została użyta przy url - get, post, put, delete
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Metoda sprawdzająca czy żadanie jest typu GET
     */
    public function isGet()
    {
        return $this->method() === 'get';
    }

    /**
     * Metoda sprawdzająca czy żadanie jest typu POST
     */
    public function isPost()
    {
        return $this->method() === 'post';
    }

    /**
     * Metoda do pobrania danych z requesta
     */
    public function getBody()
    {
        $body = [];
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                // filtrowanie requesta GET
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                // filtrowanie requesta GET
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
