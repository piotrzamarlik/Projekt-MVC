<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\Application;
use app\models\User;
use app\models\LoginForm;

/**
 * Class AuthorizationController
 */
class AuthorizationController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $this->setLayout('auth');
        $login = new LoginForm();
        if ($request->isPost()) {
            $login->loadData($request->getBody());
            if ($login->validate() && $login->login()) {
                echo '<pre>';
                var_dump('dupa logowanie');
                echo '</pre>';

                $response->redirect('/');
                return;
            }

            // return $this->render('login', [
            //     'model' => $login,
            // ]);
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
            // echo '<pre>';
            // var_dump($user);
            // echo '</pre>';
            // exit;

            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'Dziękujemy za rejestrację');
                Application::$app->response->redirect('/');
            }

            // return $this->render('register', [
            //     'model' => $user,
            // ]);
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
}
