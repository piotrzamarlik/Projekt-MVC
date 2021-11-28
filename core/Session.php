<?php

namespace app\core;

use app\core\Application;

/**
 * Class Session
 */
class Session
{
    protected const FLASH_KEY = 'flash_messages';
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // odwolanie poprzez referencję, ponieaż jeśli jej nie ma dokonujemy zmian na kopii wiadomości
        foreach ($flashMessages as $key => &$flashMessage) {
            // oznaczenie wiadomości do skasowania
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
    /**
     * Ustawienie komunikatu, który obowiązuje tylko dla jednego requesta np. po poprawnym dodaniu usera
     */
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value' => $message,
            'remove' => false
        ];
    }

    /**
     * Ustawienie danych sesji
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Pbranie danych sesji
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * Usunięcie danych z sesji
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Pobranie komunikatu, który obowiązuje tylko dla jednego requesta np. po poprawnym dodaniu usera
     */
    public function getFlash($key)
    {
        return  $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        // usunięcie wiadomości oznaczoncy hw konstruktorze jako do usunięcia
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // odwolanie poprzez referencję, ponieaż jeśli jej nie ma dokonujemy zmian na kopii wiadomości
        foreach ($flashMessages as $key => &$flashMessage) {
            // oznaczenie wiadomości do skasowania
            if ($flashMessage['remove']) {
                // usunięcie wiadomości na konkretnym kluczu a nie wszystkich
                unset($flashMessages[$key]);
            };
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
