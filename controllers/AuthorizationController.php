<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
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
            // echo '<pre>';
            // var_dump($user);
            // echo '</pre>';
            // exit;

            if ($login->validate() && $login->login()) {
                // Application::$app->session->setFlash('success', 'Poprawnie zalogowano');
                // Application::$app->response->redirect('/');
                $response->redirect('/');
                return;
            }

            // return $this->render('register', [
            //     'model' => $user,
            // ]);
        }
        return $this->render('login', [
            'model' => $user,
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
}
