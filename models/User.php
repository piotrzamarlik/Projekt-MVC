<?php

namespace app\models;

use app\core\DbModel;

class User extends DbModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public int $status = self::STATUS_INACTIVE;

    public function getTableName(): string
    {
        return 'users';
    }

    public function getAttributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password', 'status'];
    }
    // metoda przeciążająca metodę rodzica dotyczącą nazw pól label
    public function labels(): array
    {
        return [
            'firstname' => 'Imię', 
            'lastname' => 'Nazwisko', 
            'email' => 'Adres emial', 
            'password' => 'Hasło',
            'confirmPassword' => 'Powtórz hasło',
        ];
    }

    // metoda przeciążająca metodę rodzica
    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        // wywołanie metody zapisu rodzica DbModel po zhasowaniui hasła
        return parent::save();
    }

    /**
     * Implementacja metody rules()
     */
    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                    //to pole musi być unikalne dla tej klasy z modelu bazy danych
                    // tutaj klasa będzie Usera
                    self::RULE_UNIQUE, 'class' => self::class
                ]
            ],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 20]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
