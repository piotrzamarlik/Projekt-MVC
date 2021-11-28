<?php

namespace app\models;

use app\core\Model;
use app\core\Application;

class ContactForm extends Model
{
    public string $title = '';
    public string $email = '';
    public string $description = '';

    /**
     * Implementacja metody rules()
     */
    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'description' => [self::RULE_REQUIRED],
        ];
    }

    // metoda przeciążająca metodę rodzica dotyczącą nazw pól label
    public function labels(): array
    {
        return [
            'title' => 'Tytuł', 
            'email' => 'Adres emial', 
            'description' => 'Treść wiadomości',
        ];
    }
}
