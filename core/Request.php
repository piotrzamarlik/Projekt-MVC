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
        echo '<pre>';
        var_dump($position);
        echo '</pre>';
        exit;
    }

    /**
     * 
     */
    public function getMethod()
    {

    }
}