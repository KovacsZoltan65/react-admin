<?php

/**
 * BaseField.php
 * User: kzoltan
 * Date: 2022-06-26
 * Time: 16:50
 */

namespace app\core\form;

use app\core\Model;

/**
 * Description of BaseField
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */
abstract class BaseField
{
    abstract public function renderInput(array $arr): string;
 
    public Model $model;
    public string $attribute;
    
    const TYPE_TEXT     = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_FILE     = 'file';
    const TYPE_NUMBER   = 'number';
    const TYPE_EMAIL    = 'email';
    const TYPE_COLOR    = 'color';
    const TYPE_DATE     = 'date';
    const TYPE_HIDDEN   = 'hidden';
    const TYPE_TIME     = 'time';
    const TYPE_WEEK     = 'week';
    
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    
    public function __toString()
    {
        $arr = $this->model->getClasses($this->attribute);
        
        if( !isset($this->type) )
        {
            $this->type = '';
        }
        
        switch ($this->type)
        {
            case self::TYPE_HIDDEN:
                $str = $this->renderInput($arr);
                break;
            default:
                $str = '
                    <div class="form-group">
                        <label for="'.$this->attribute.'">' . $this->model->getLabel($this->attribute) . '</label>'.
                        $this->renderInput($arr)
                        .'<div id="'.$this->attribute.'Help" name="'.$this->attribute.'Help" 
                         class="' . $arr['class_2'] . '"
                         >' . $this->model->getFirstError($this->attribute) . '</div>
                    </div>
                ';
                break;
        }
        
        

        return $str;
    }
}
