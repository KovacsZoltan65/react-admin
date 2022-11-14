<?php

/**
 * Company.php
 * User: kzoltan
 * Date: 2022-05-18
 * Time: 08:30
 */

namespace app\models;

use app\core\Application;
use app\core\db\DbModel;
use app\core\Language;

/**
 * Description of Company
 * Class Company
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\models
 * @version 1.0
 */
class Company extends DbModel
{
    public int $id = 0,
        $status = 1,
        $country_id = 0;
    public string $name = '',
        $currency = '';
    
    public function __construct()
    {
        //$this->mod_u_id = $_SESSION['user'];
        parent::__construct();
        /*
        foreach( $this->attributes() as $attribute)
        {
            $this->$attribute;
        }
        */
    }
    
    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        array_push($attributes, 'mod_u_id');
        $params = array_map(fn($attr) => ":$attr", $attributes);
        
        if( $this->{$this->primaryKey()} == 0 )
        {
            $query = "INSERT INTO $tableName(" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ");";
        }
        else
        {
            $set = '';
            $where = '';
            for( $i = 0; $i < count($attributes); $i++ )
            {
                if( $attributes[$i] != $this->primaryKey() )
                {
                    if( strlen($set) != 0 )
                    {
                        $set .= ', ';
                    }
                    $set .= " $attributes[$i] = $params[$i] ";
                }
                else
                {
                    $where = "{$attributes[$i]} = {$params[$i]}";
                }
            }
            $query = "UPDATE $tableName SET $set WHERE $where;";
        }

        $statement = self::prepare($query);

        foreach($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();

        return true;
    }

    public function delete()
    {
        $tableName = $this->tableName();
        $idField = $this->primaryKey();
        $attributes = [];
        $params = [];

        if( Application::$app->getConfig('delete') == 'soft_delete' )
        {
            $this->status = self::STATUS_INACTIVE;
            $attributes = ['status', 'mod_u_id', 'id'];
            $params = array_map(fn($attr) => ":$attr", $attributes);

            $query = "UPDATE $tableName SET
                status = " . $params[0] . ",
                mod_u_id = " . $params[1] . "
                WHERE $idField = " . $params[2] . ";";
        }
        else
        {
            $query = "DELETE FROM $tableName WHERE id = " . $params[0] . ";";
            $attributes = ['id'];
            $params = array_map(fn($attr) => ":$attr", $attributes);
        }

        $statement = self::prepare($query);

        foreach( $attributes as $attribute )
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();

        return true;
    }
    
    public function insert()
    {
        //
    }
    
    public function update()
    {
        //
    }
    
    /**
     * 
     * @return array
     */
    public function attributes(): array
    {
        return ['id', 'name', 'status','currency','country_id'];
    }

    /**
     * Szabályok
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'currency' => [self::RULE_REQUIRED],
            'company_id' => [
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min' => 1]
            ],
        ];
    }

    /**
     * Címkék
     * @return array
     */
    public function labels(): array
    {
        return [
            'name' => Language::trans('name'),
            'country' => Language::trans('country'),
            'currency' => Language::trans('currency'),
        ];
    }
    
    /**
     * Elsődleges kulcs mező neve
     * @return string
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * Tábla neve
     * @return string
     */
    public static function tableName(): string
    {
        return 'companies';
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country_id' => $this->country_id,
            'currency' => $this->currency,
            'status' => $this->status,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->country_id = $data['country_id'];
        $this->currency = $data['currency'];
        $this->status = $data['status'];
    }

    public function __toString(): string
    {
        return "$this->id;$this->name;$this->country_id;$this->currency;$this->status";
    }
}
