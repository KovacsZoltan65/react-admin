<?php

/**
 * Permission.php
 * User: kzoltan
 * Date: 2022-10-21
 * Time: 10:15
 */

namespace app\models;

/**
 * Description of Company to Person
 *
 * @author kzoltan
 */
class c2p extends \app\core\db\DbModel
{
    public int $id,
        $company_id,
        $human_id,
        $status;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        array_push($atributes, 'mod_u_id');
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

        foreach( $attributes as $attribute )
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
    
    public function attributes(): array
    {
        return ['id','company_id','human_id','status'];
    }
    
    /**
     * Szabályok
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => [self::RULE_REQUIRED],
            'company_id' => [self::RULE_REQUIRED],
            'human_id' => [self::RULE_REQUIRED],
            'status' => [self::RULE_REQUIRED],
        ];
    }
    
    /**
     * Elsődleges kulcs
     * @return string
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'c2p';
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'human_id' => $this->human_id,
            'status' => $this->status,
        ];
    }
    public function __unserialize(array $data)
    {
        $this->id = $data['id'];
        $this->company_id = $data['company_id'];
        $this->human_id = $data['human_id'];
        $this->status = $data['status'];
    }
    public function __toString(): string
    {
        return "$this->id,$this->company_id,$this->human_id,$this->status";
    }
}
