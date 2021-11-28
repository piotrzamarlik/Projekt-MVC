<?php

namespace app\core;

/**
 * Class View
 */
class View
{
    public string $title = '';

    /**
     * Render widoku z przekazanej zmiennej z $callback
     */
    public function renderView($view, $params = [])
    {
        // pobranie treści layout'u
        $viewContent = $this->viewContent($view, $params);
        // pobranie szablonu layout'u
        $layoutContent = $this->layoutContent();
        // zastąpienie zmiennej {{content}} w szablonie treścią konkretnego widoku i zwrócenie do przeglądarki
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Metoda pobierająca treść do wyświetlenia szablonu
     */
    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
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
    protected function viewContent($view, $params)
    {
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