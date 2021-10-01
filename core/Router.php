<?php

namespace app\core;

/**
 * Class Router
 */
class Router
{

    public Request $request;
    public Response $response;
    // tablica z routingiem
    protected array $routes = [];

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
            $this->response->setStatusCode(404);
            return $this->renderView("404");
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            // wstawienie instacji  obiektu na indeks 0 w callback z np. ContactPageController::class
            // bez tego zwracany jest string i w metodzie render w kontorlerze $this jest stringiem a nie obiektem
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        // przesłanie callback i dodatkowego parametru $requesta, tak aby był dostępny w kontrolerze
        return call_user_func($callback, $this->request);
        // echo '<pre>';
        // var_dump($callback);
        // echo '</pre>';
        // exit;
    }

    /**
     * Render widoku z przekazanej zmiennej z $callback
     */
    public function renderView($view, $params = []) {
        // pobranie szablonu layout'u
        $layoutContent = $this->layoutContent();
        // pobranie treści layout'u
        $viewContent = $this->viewContent($view, $params);
        // zastąpienie zmiennej {{content}} w szablonie treścią konkretnego widoku i zwrócenie do przeglądarki
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Metoda pobierająca treść do wyświetlenia szablonu
     */
    protected function layoutContent() {
        $layout = Application::$app->controller->layout;
        // rozpczęcie output caching, nic nie wyświetli się w przeglądarce
        ob_start();
        // to jest aktualny stan do zwrócenia w przeglądarce (w metodzie renderView)
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        // zwrócenie tego co zostało z cache'owane i czyści bufor
        return ob_get_clean();
    }

    /**
     * Metoda pobierająca treść do wyświetlenia szablonu
     */
    protected function viewContent($view, $params) {
        // Dzięki tej pętli załączanie pliku będzie miało dostępne wartości z tablicy
        foreach ($params as $key => $value) {
            // $key => 'name', $$key oznacza, że $key jest zmienną o nazwie name, której wartość jest $value
            $$key = $value;
        }
        // rozpczęcie output caching, nic nie wyświetli się w przeglądarce
        ob_start();
        // to jest aktualny stan do zwrócenia w przeglądarce (w metodzie renderView)
        include_once Application::$ROOT_DIR . "/views/$view.php";
        // zwrócenie tego co zostało z cache'owane i czyści bufor
        return ob_get_clean();
    }
}