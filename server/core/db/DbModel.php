<?php

/**
 * DbModel.php
 * User: kzoltan
 * Date: 2022-06-21
 * Time: 14:30
 */

namespace app\core\db;

use app\core\Application;
use app\core\Model;
use PDO;
use PDOStatement;

/**
 * Description of DbModel
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\db
 * @version 1.0
 */
abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    const INT_TRUE = 1,
        INT_FALSE = 0;

    /**
     * Adatok mentése
     * @version 1.0
     * @return boolean
     */
    public function save()
    {
        // Táblanév lekérése
        $tableName = $this->tableName();
        // Paraméterek
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        
        //$params = array_map( function($attr){ return ":$attr"; }, $attributes );
        // Futtatndó lekérdezés
        $query = "INSERT INTO $tableName(" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ");";
        // Előkészítés
        $statement = self::prepare($query);
        // Paraméterek kötése
        foreach ($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        // Futtatás
        $res = $statement->execute();
        // true: sikeres | false: sikertelen futás
        return $res;
    }

    public function update()
    {
        // Táblanév lekérése
        $tableName = $this->tableName();
        // Paraméterek
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        
        /*
            UPDATE mvc_framework.users SET 
            password = ?, 
            mod_u_id = ? 
            WHERE id = ?;
         */
        
        $query = "UPDATE $tableName SET ";
        
        foreach($attributes as $attribute)
        {
            echo '<pre>';
            var_dump($this->{$attribute});
            echo '</pre>';
            
            if( !is_null($this->{$attribute}) && $this->{$attribute} != '' )
            {
                $query .= " $attribute = :$attribute ";
            }
        }
        
        echo '<pre>';
        var_dump($query);
        echo '</pre>';
        exit;
    }
    
    public function delete()
    {
        // Táblanév lekérése
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $query = "";
    }

    /**
     * Egy rekord lekérése az adatbázisból az átadott paraméterek alapján.
     * 
     * @param array $where Lekéréshez szükséges paraméterek
     * @return object
     */
    public static function findOne(array $where)
    {
        // Táblanév lekérése
        $tableName = static::tableName();
        // Feltételek
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        // Előkészítés
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql;");

        foreach ($where as $key => $item)
        {
            $statement->bindValue(":$key", $item);
        }
        // Futtatás
        $statement->execute();
        // Eredmény az aktuális osztállyá alakítva
        $retval = $statement->fetchObject(static::class);
        
        return $retval;
    }

    /**
     * Keresés az adattáblában a megadott paraméterek alapján.
     * Tö
     * @version 1.0
     * @param array $where
     * @return array<object>
     */
    public static function find(array $where)
    {
        // Táblanév lekérése
        $tableName = static::tableName();
        
        // Feltételek
        $attributes = array_keys($where);
        
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $query = "SELECT * FROM $tableName WHERE $sql;";
        
        // Előkészítés
        $statement = self::prepare($query);
        // Paraméterek kötése
        foreach ($where as $key => $item)
        {
            $statement->bindValue(":$key", $item);
        }
        // Futtatás
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
    }
    /**
     * Adattábla összes rekordjának lekérése
     * @version 1.0
     * @return array
     */
    public static function getAll(): array
    {
        // Táblanév lekérése
        $tableName = static::tableName();
        // Futtatandó lekérdezés
        $sql = "SELECT * FROM $tableName;";
        // Előkészítés
        $statement = self::prepare($sql);
        // Futtatás
        $statement->execute();
        // Eredményhalmaz osztállyá alakítás, és visszaküldés
        return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    /**
     * Adatbáziskérés előkészítése
     * @version 1.0
     * @param string $sql Lekérdezés
     * @return \PDOStatement|false
     */
    public static function prepare(string $sql): \PDOStatement|false
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    /**
     * Rekord státusz azonosítójának szöveges értéke
     * @return string
     */
    public function getStatusName(): string
    {
        // Visszetérő érték
        $status_name = '';
        
        if ($this->status === 0)
        {
            $status_name = self::STATUS_INACTIVE;
        }
        elseif ($this->status === 1)
        {
            $status_name = self::STATUS_ACTIVE;
        }
        elseif ($this->status === 2)
        {
            $status_name = self::STATUS_DELETED;
        }
        // Érték visszaküldése
        return $status_name;
    }
    
    /**
     * Előkészítés
     */
    public function __construct()
    {
        // Ősosztály előkészítése
        parent::__construct();
    }
}
