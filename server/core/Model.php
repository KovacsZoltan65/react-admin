<?php

/**
 * Model.php
 * User: kzoltan
 * Date: 2022-05-18
 * Time: 09:00
 */

namespace app\core;

/**
 * Description of Model
 * Class Model
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
abstract class Model
{
    public const RULE_REQUIRED = 'required', 
        RULE_EMAIL = 'email', 
        RULE_MIN = 'min', 
        RULE_MAX = 'max', 
        RULE_MATCH = 'match',
        RULE_UNIQUE = 'unique';
    
    public const STATUS_INACTIVE = 0,
        STATUS_ACTIVE = 1,
        STATUS_DELETED = 2;

    //public array $errors = [];
    
    public int $mod_u_id = 0;
    
    public function __construct()
    {
        if( isset($_SESSION['user']) )
        {
            $this->mod_u_id = $_SESSION['user'];
        }
    }
    
    /**
     * Adatok vizsgálatának szabályai
     */
    abstract public function rules(): array;
    
    /**
     * Oldal feliratai. 
     * Esetleges nyelvesítés itt lehet lekezelni.
     * @return array
     */
    public function labels(): array
    {
        return [];
    }
    
    /**
     * Címke lekérése
     * @param string $attribute
     * @return string
     */
    public function getLabel(string $attribute): string
    {
        return $this->labels()[$attribute] ?? $attribute;
    }
    
    /**
     * Adatok betöltése a modelbe
     * @param array $data    Adatok
     */
    public function loadData($data)
    {
        foreach($data as $key => $value)
        {
            if( property_exists($this, $key) )
            {
                $this->{$key} = $value;
            }
        }
    }
    
    /**
     * Űrlapfelől jövő adatok ellenőrzése
     * @return array
     */
    public function validate()
    {
        foreach( $this->rules() as $attribute => $rules )
        {
            $value = $this->{$attribute};
            foreach( $rules as $rule )
            {
                $ruleName = $rule;
                if( !is_string($ruleName) )
                {
                    $ruleName = $rule[0];
                }
                if( $ruleName === self::RULE_REQUIRED && !$value )
                {
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }
                if( $ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL) )
                {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }
                if( $ruleName === self::RULE_MIN && strlen($value) < $rule['min'] )
                {
                    $this->addErrorByRule($attribute, self::RULE_MIN, $rule);
                }
                if( $ruleName === self::RULE_MAX && strlen($value) > $rule['max'] )
                {
                    $this->addErrorByRule($attribute, self::RULE_MAX, $rule);
                }
                if( $ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']} )
                {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorByRule($attribute, self::RULE_MATCH, $rule);
                }
                if( $ruleName === self::RULE_UNIQUE )
                {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr;");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    
                    if( $record )
                    {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }
    
    protected function addErrorByRule(string $attribute, string $rule, $params = [])
    {
        $params['field'] ??= $attribute;
        $errorMessage = $this->errorMessage($rule);
        foreach ($params as $key => $value)
        {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }
        $this->errors[$attribute][] = $errorMessage;
    }
    
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }
    
    /**
     * 
     * @return array
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL    => 'This field must be valid email address',
            self::RULE_MIN      => 'Min length of this field must be {min}',
            self::RULE_MAX      => 'Max length of this field must be {max}',
            self::RULE_MATCH    => 'This field must be the same as {match}',
            self::RULE_UNIQUE   => 'Record with this {field} already exists.',
        ];
    }
    
    public function errorMessage($rule)
    {
        return $this->errorMessages()[$rule];
    }
    
    /**
     * 
     * @param string $attribute
     * @return type
     */
    public function hasError(string $attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    
    /**
     * Első hibaüzenet lekérése a megjelenítéshez.
     * Ha nincs, akkor hamis értéket ad vissza.
     * @param string $attribute
     * @return type
     */
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
    
    /**
     * Megjelenítési osztály lekérése a keletkezett hiba alapján
     * @param type $field
     * @return array
     */
    public function getClasses($field): array
    {
        $class_1 = '';
        $class_2 = '';
        if( $this->$field == '' && is_bool($this->hasError($field)) )
        {
            $class_1 = '';
            $class_2 = '';
        }
        elseif( $this->$field == '' && !is_bool($this->hasError($field)) )
        {
            $class_1 = ' is-invalid';
            $class_2 = 'invalid-feedback';
        }
        elseif( $this->$field != '' && is_bool($this->hasError($field)) )
        {
            $class_1 = ' is-valid';
            $class_2 = 'valid-feedback';
        }
        elseif( $this->$field != '' && !is_bool($this->hasError($field)) )
        {
            $class_1 = ' is-invalid';
            $class_2 = 'invalid-feedback';
        }
        
        $arr = [
            'class_1' => $class_1,
            'class_2' => $class_2,
        ];
        
        return $arr;
    }

    

}
