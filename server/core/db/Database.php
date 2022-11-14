<?php

/**
 * Database.php
 * User: kzoltan
 * Date: 2022-05-19
 * Time: 07:20
 */

namespace app\core\db;

/**
 * Description of Database
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\db
 * @version 1.0
 */
class Database
{
    public \PDO $pdo;
    
    /**
     * Konstruktor
     * @version 1.0
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        
        $this->pdo = new \PDO($dsn, $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
        $sql = "set @disable_trigger = " . $config['app_mode_dev'] . ";";
        $this->pdo->exec($sql);
    }
    
    /**
     * Migráció végrehajtása
     * @version 1.0
     *
     * @return void
     */
    public function applyMigrations()
    {
        // Migrációs tábla elkészítése, ha még nem létezne
        $this->createMigrationsTable();
        
        // Végrehajtott migrácuók lekérése
        $appliedMigrations = $this->getAppliedMigrations();
        
        $newMigrations = [];
        
        // Migrációs fájlok lekérése
        $files = scandir(Application::$ROOT_DIR . '/migrations');
        
        // Végrehajtandó migrációk halmaza
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        
        // Migráció 
        foreach($toApplyMigrations as $migration)
        {
            if( $migration === '.' || $migration === '..' )
            {
                continue;
            }
            
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className;
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }
        
        if( !empty($newMigrations) )
        {
            $this->saveMigrations($newMigrations);
        }
        else
        {
            $this->log('All migrations are applied');
        }
        
    }
    
    /**
     * Migrációs tábla létrehozása, ha még nem létezik
     * @version 1.0
     *
     * @return int|bool
     */
    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            nigration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE = INNODB;");
    }
    
    /**
     * Végrehajtott migrácuók lekérése
     * @version 1.0
     *
     * @return array
     */
    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations;");
        $statement->execute();
        
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     *
     * Végrehajtott migráció mentése
     * @version 1.0
     *
     * @param array $migrations
     * @return bool
     */
    public function saveMigrations(array $migrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration)VALUES $str;");
        $statement->execute();
    }

    /**
     *
     * @param type $sql
     * @return \PDOStatement|bool
     */
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }


    protected function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message. PHP_EOL;
    }
    
}
