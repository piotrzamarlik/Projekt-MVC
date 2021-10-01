<?php

namespace app\core;

/**
 * Class Database
 */
class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $migrated = $this->getMigrations();
        // tablica do przechowania dodanych nowych migracji
        $addedMigrations = [];
        // pliki z migracjami
        $migrations = scandir(Application::$ROOT_DIR . '/migrations');
        // migracje, które musza zostać wykonane
        $newMigrations = array_diff($migrations, $migrated);

        foreach ($newMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $calssName = pathinfo($migration, PATHINFO_FILENAME);
            $instanceClass = new $calssName();
            $this->log("Migracja, która jest dodawana $migration");
            $instanceClass->up();
            $this->log("Migracja, która została dodana $migration");
            // dodanie migracji do tablicy pomocniczej, która zawiera wykonane nowe migracje
            $addedMigrations[] = $migration;
        }

        if (!empty($addedMigrations)) {
            $this->saveMigrations($addedMigrations);
        } else {
            $this->log("Wszystkie migracje są aktualne");
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id SERIAL PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
    }

    public function getMigrations()
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM migrations");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $strMigrations = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $strMigrations");
        $stmt->execute();
    }

    protected function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' .$message . PHP_EOL;
    }
}