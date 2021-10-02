<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Application;
use app\models\User;

/**
 * Class AuthorizationController
 */
class AuthorizationController extends Controller
{
    public function login(Request $request)
    {
        $this->setLayout('auth');
        return $this->render('login');
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
