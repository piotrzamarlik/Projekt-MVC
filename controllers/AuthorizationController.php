<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Register as RegisterModel;

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
        $register = new RegisterModel();
        if ($request->isPost()) {
            $register->loadData($request->getBody());
            // echo '<pre>';
            // var_dump($register);
            // echo '</pre>';
            // exit;

            if ($register->validate() && $register->register()) {
                echo 'Succes';
            }

            return $this->render('register', [
                'model' => $register,
            ]);
        }
        return $this->render('register', [
            'model' => $register,
        ]);
    }
}
