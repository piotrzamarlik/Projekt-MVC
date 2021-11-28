<?php

namespace app\core;

/**
 * Class DbModel
 */
abstract class DbModel extends Model
{
    abstract public function getTableName(): string;
    abstract public function getAttributes(): array;
    abstract public function primaryKey(): string;

    public function save()
    {
        $tableName = $this->getTableName();
        $attributes = $this->getAttributes();
        $params = array_map(fn($p) => ":$p", $attributes);
        $stmt = self::prepare("
            INSERT INTO $tableName (" . implode(',', $attributes) . ")
            VALUES (" . implode(',', $params) . ")
        ");
        foreach ($attributes as $attribute) {
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }
        $stmt->execute();
        return true;
    }

    public static function findOne($where)
    {
        // przez to, że metoda jet abstrakcyjna trzeba pobrać instację klasy obecnie obowiązującej
        $className = static::class;
        // wywolanie nowego obiektu klasy
        $context = new $className();
        $tableName = $context->getTableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($p) => "$p = :$p", $attributes));
        $stmt = self::prepare("
            SELECT * FROM $tableName
            WHERE $sql
        ");

        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }
        $stmt->execute();
        // zwrócenie instacji obiektu klasy user
        return $stmt->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
       return Application::$app->db->pdo->prepare($sql);
    }
}