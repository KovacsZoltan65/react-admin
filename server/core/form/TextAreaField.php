<?php

/**
 * TextArea.php
 * User: kzoltan
 * Date: 2022-06-26
 * Time: 18:30
 */

namespace app\core\form;

use app\core\Model;

/**
 * Description of TextArea
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */
class TextAreaField extends BaseField
{
    public Model $model;
    public string $attribute;
    
    public function __construct(Model $model, string $attribute)
    {
        parent::__construct($model, $attribute);
    }
    
    //put your code here
    public function renderInput(array $arr): string
    {
        return '<textarea 
            id="' . $this->attribute . '" 
            name="' . $this->attribute . '" 
            class="form-control' . $arr['class_1'] . '"
            >' . $this->model->{$this->attribute} . '</textarea>';
    }

}
