<?php

namespace app\models;

use app\core\Model;
use app\core\Application;

class LoginForm extends Model
{
    public string $email;
    public string $password;

    /**
     * Implementacja metody rules()
     */
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'Brak takiego użytkownika w systemie');
            return false;
        }

        if (password_verify($this->password, $user->password)) {
            $this->addError('password', 'Nieprawidłowe hasło');
            return false;
        }
        Application::$app->login();
    }

    // public function hasError($attribute)
    // {
    //     return $this->errors[$attribute] ?? false;
    // }

    // public function getFirstError($attribute)
    // {
    //     return $this->errors[$attribute][0] ?? false;
    // }
}
