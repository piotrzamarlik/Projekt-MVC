<?php

namespace app\core;

use app\core\Application;

/**
 * Class Model
 */
abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public $errors = [];

    /**
     * Ładowanie danych z requesta
     */
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Meotda abstrakcyjna dotycząca reguł walidacji
     */
    abstract public function rules(): array;

    // meetoda zwracająca pusta tablicę. Metode można nadpisać w klasie dziedziczącej
    public function labels(): array
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }
    /**
     * Walidacja danych z requesta
     */
    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                // jeśli ruleName jest tablicą
                if (is_array($ruleName)) {
                    $ruleName = $rule[0];
                }
                // jeśli rule jest równy required i wartość nie istnieje
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                // walidacja email
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                // walidacja min
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                // walidacja max
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                // walidacja zgodności haseł
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
                 // walidacja unikalności maila
                 if ($ruleName === self::RULE_UNIQUE) {
                    // && $value !== $this->{$rule['unique']}
                    // pobranie nazwy klasy z modelu, który definiuje rules()
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::getTableName();
                    $stmt = Application::$app->db->prepare("
                        SELECT * FROM $tableName
                        WHERE $uniqueAttribute = :$uniqueAttribute
                    ");
                    $stmt->bindValue(":$uniqueAttribute", $value);
                    $stmt->execute();
                    $exists = $stmt->fetchObject();
                    if ($exists) {
                        $this->addError($attribute, self::RULE_UNIQUE, ['email' => $this->getLabel($attribute)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * Dodanie błędów do tablicy
     */
    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    /**
     * Komunikaty błędów
     */
    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'Pole jest wymagane',
            self::RULE_EMAIL => 'Adres email musi mieć poprawny format',
            self::RULE_MIN => 'Minimalna liczba znaków to {min}',
            self::RULE_MAX => 'Maksymalna liczba znaków to {max}',
            self::RULE_MATCH => 'Pole musi się zgadzać z polem {match}',
            self::RULE_UNIQUE => '{email} istnieje już w systemie',
        ];
    }
}
