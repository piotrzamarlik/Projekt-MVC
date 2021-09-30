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
    public function getMethod()
    {
        // zwrócenie metody, jaka została użyta przy url - get, post, put, delete
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}