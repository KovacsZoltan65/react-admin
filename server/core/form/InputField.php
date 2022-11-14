<?php

/**
 * InputField.php
 * User: kzoltan
 * Date: 2022-05-18
 * Time: 13:20
 */

namespace app\core\form;

use app\core\Model;



/**
 * Description of Field
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */

class InputField extends BaseField
{
    public Model $model;
    public string $attribute, 
        $type;
    
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }
    
    public function renderInput(array $arr): string
    {
        $str = '';
        /*
        $str = '
                <input type="' . $this->type . '" 
                       name="' . $this->attribute . '" id="' . $this->attribute . '"
                       value="' . $this->model->{$this->attribute} . '" 
                       class="form-control' . $arr['class_1'] . '" ' . 
                       ( $this->type == self::TYPE_NUMBER ? 'min="" max=""':'' ) . ' 
                       aria-describedby="' . $this->attribute . 'Help" />';
        */
        switch($this->type)
        {
            case '':
            case 'hidden':
                $str = '<input id="' . $this->attribute . '" 
                               name="' .$this->attribute . '" 
                               type="' . $this->type . '" 
                               value="' . $this->model->{$this->attribute} . '" />';
                break;    
            case 'number':
                $str = '<input type="' . $this->type . '" 
                               name="' . $this->attribute . '" id="' . $this->attribute . '" 
                               value="' . $this->model->{$this->attribute} . '" nim="" max=""
                               class="form-control' . $arr['class_1'] . '" 
                               aria-describeddy="' . $this->attribute . 'Help" />';
                break;
            default:
                $str = '
                    <input type="' . $this->type . '" 
                           name="' . $this->attribute . '" id="' . $this->attribute . '"
                           value="' . $this->model->{$this->attribute} . '" 
                           class="form-control' . $arr['class_1'] . '" 
                           aria-describedby="' . $this->attribute . 'Help" />';
                break;
        }
        
        return $str;
    }
    
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function fileField()
    {
        $this->type = self::TYPE_FILE;
        return $this;
    }
    
    public function emailField()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }
    
    public function colorField()
    {
        $this->type = self::TYPE_COLOR;
        return $this;
    }
    
    public function dateField()
    {
        $this->type = self::TYPE_DATE;
        return $this;
    }
    
    public function hiddenField()
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
    }
    
    public function numberField()
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }
    
    public function timeField()
    {
        $this->type = self::TYPE_TIME;
        return $this;
    }
    
    public function weekField()
    {
        $this->type = self::TYPE_WEEK;
        return $this;
    }
}