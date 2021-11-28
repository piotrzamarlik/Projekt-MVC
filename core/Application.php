<?php

namespace app\core;

/**
 * Class Application
 */
class Application
{
    public string $layout = 'main';
    public static string $ROOT_DIR;
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;
    public static Application $app;
    public ?Controller $controller = null;
    public ?UserModel $user;
    public View $view;

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
        $this->view = new View();
        $this->db = new Database($config['db']);
        $this->userClass = $config['userClass'];
        $user = new $this->userClass();
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $user->primaryKey();
            $this->user = $user->findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    /**
     * Uruchomienie aplikacji
     */
    public function run()
    {
        try {
        // wyświetlenie cokolwiek zostało zwrócone z routera
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('error', [
                "exception" => $e
            ]);
        }
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

    /**
     * @return \app\core\DbModel
     */
    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    /**
     * @return \app\core\DbModel
     */
    public function logout()
    {
        $this->user = null;
        self::$app->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}
