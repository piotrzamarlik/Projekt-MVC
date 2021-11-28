<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\Application;
use app\core\middlewares\AuthMiddleware;
use app\models\User;
use app\models\LoginForm;

/**
 * Class AuthorizationController
 */
class AuthorizationController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
        $this->setLayout('auth');
        $login = new LoginForm();
        if ($request->isPost()) {
            $login->loadData($request->getBody());
            if ($login->validate() && $login->login()) {
                $response->redirect('/');
                return;
            }
        }
        
        return $this->render('login', [
            'model' => $login,
        ]);

    }

    /**
     * Rejestracja użytkownika
     */
    public function register(Request $request)
    {
        $this->setLayout('auth');
        $user = new User();
        if ($request->isPost()) {
            $user->loadData($request->getBody());
            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'Dziękujemy za rejestrację');
                Application::$app->response->redirect('/');
            }
        }
        return $this->render('register', [
            'model' => $user,
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        
        return $this->render('profile');
    }
}
