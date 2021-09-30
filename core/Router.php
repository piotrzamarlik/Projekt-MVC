<?php

namespace app\core;

/**
 * Class Router
 */
class Router
{

    public Request $request;
    // tablica z routingiem
    protected array $routes = [];

    public function __construct(\app\core\Request $request)
    {
        $this->request = $request;
    }
    /**
     * Get method - dodanie to routingu ścieżki i akcji zwrotnej
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        // pobranie ścieżki z requesta
        $path = $this->request->getPath();
        // pobranie metody z requesta - GET, POST, PUT, DELETE
        $method = $this->request->getMethod();
        // pobranie akcji na dany routing
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
    }

    /**
     * Render widoku z przekazanej zmiennej z $callback
     */
    public function renderView($view) {
        // pobranie szablonu layout'u
        $layoutContent = $this->layoutContent();
        // pobranie treści layout'u
        $viewContent = $this->viewContent($view);
        // zastąpienie zmiennej {{content}} w szablonie treścią konkretnego widoku i zwrócenie do przeglądarki
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Metoda pobierająca treść do wyświetlenia szablonu
     */
    protected function layoutContent() {
        // rozpczęcie output caching, nic nie wyświetli się w przeglądarce
        ob_start();
        // to jest aktualny stan do zwrócenia w przeglądarce (w metodzie renderView)
        include_once Application::$ROOT_DIR . "/views/layouts/main.php";
        // zwrócenie tego co zostało z cache'owane i czyści bufor
        return ob_get_clean();
    }

    /**
     * Metoda pobierająca treść do wyświetlenia szablonu
     */
    protected function viewContent($view) {
        // rozpczęcie output caching, nic nie wyświetli się w przeglądarce
        ob_start();
        // to jest aktualny stan do zwrócenia w przeglądarce (w metodzie renderView)
        include_once Application::$ROOT_DIR . "/views/$view.php";
        // zwrócenie tego co zostało z cache'owane i czyści bufor
        return ob_get_clean();
    }
}