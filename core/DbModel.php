<?php

namespace app\core;

/**
 * Class DbModel
 */
abstract class DbModel extends Model
{
    abstract public function getTableName(): string;
    abstract public function getAttributes(): array;

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

    public static function prepare($sql)
    {
       return Application::$app->db->pdo->prepare($sql);
    }
}