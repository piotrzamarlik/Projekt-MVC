<?php

namespace app\core;

/**
 * Class Response
 */
class Response
{
    /**
     * Ustawienie kodu odpowiedzi z serwera
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * PRzekierowanie
     */
    public function redirect(string $url)
    {
        echo '<pre>';
                var_dump('dupa response');
                echo '</pre>';
        header('Location: ' . $url);
    }
}
