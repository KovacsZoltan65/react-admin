<?php

/**
 * Select.php
 * User: kzoltan
 * Date: 2022-10-04
 * Time: 18:15
 */

namespace app\core\form;

use app\core\Model;

/**
 * Description of Select
 *
 * @author kzoltan
 */
class Select
{
    private Model $model;

    /*
     * @param array $attributes
     * [
     *      'id' => '',
     *      'name' => '',
     *      'value_id' => '',
     *      'value_field' => '',
     *      'selected_id' => '',
     *      'selected_field' => '',
     *      'title_id' => '',
     *      'title_field' => '',
     *      'data' => [],
     *      '' => '',
     * ]
     */
    public array $attributes = [];
    public int $value_id, 
        $selected_id;
    public string $value_field, 
        $selected_field, 
        $title_field;
    
    public function __construct(Model $model, array $attributes)
    {
        $this->model = $model;
        $this->attributes = $attributes;
    }
    
    public function __toString()
    {
        $name = ( !isset($this->attributes['name']) || $this->attributes['name'] == '' ) ? $this->attributes['id'] : $this->attributes['name'];
        $style = ( isset($this->attributes['style']) ? 'style="' . $this->attributes['style'] . '"' : '' );
        
        $str = '<select id="' . $this->attributes['id'] . '" 
                        name="' . $name . '" 
                        class="' . $this->attributes['class'] . '" 
                        ' . $style . '
                >';
        
        $value_field = $this->attributes['value_field'];
        $selected_field = $this->attributes['selected_field'];
        $model_selected_field = $this->attributes['model_selected_field'];
        $title_field = $this->attributes['title_field'];
        
        $options = '';
        if( isset($this->attributes['blank_row']) )
        {
            if( is_array($this->attributes['blank_row']) )
            {
                $options .= '<option value="' . $this->attributes['blank_row']['id'] . '">' . $this->attributes['blank_row']['title'] . '</option>';
            }
            elseif(is_bool($this->attributes['blank_row']) && $this->attributes['blank_row'] )
            {
                $options .= '<option value="">VÁLASSZ</option>';
            }
        }
        
        foreach( $this->attributes['data'] as $key => $d )
        {
            $selected = '';
            
            if( isset($this->model->$model_selected_field) && isset($d->$selected_field) )
            {
                if(
                    $this->model->$model_selected_field != 0 && 
                    $d->$selected_field == $this->model->$model_selected_field 
                )
                {
                    $selected = 'selected';
                }
            }
            
            $options .= '<option value="' . $d->$value_field . '" ' . $selected . ' >' . $d->$title_field . '</option>';
        }
        
        $name = ( !isset($this->attributes['name']) || $this->attributes['name'] == '' ) ? $this->attributes['id'] : $this->attributes['name'];
        $arr = $this->model->getClasses($this->attributes['id']);
        
        $select = '<div class="form-group">
            <label for="' . $this->attributes['id'] . '">' . $this->model->getLabel($this->attributes['title']) . '</label>
                <select class="' . $this->attributes['class'] . $arr['class_1'] . '" 
                        id="' . $this->attributes['id'] . '" 
                        name="' . $name . '" >
                    ' . $options . '
                </select>
                <div id="' . $this->attributes['model_selected_field'] . 'Help" name="' . $this->attributes['model_selected_field'] . 'Help" 
                     class="' . $arr['class_2'] . '">' . $this->model->getFirstError($this->attributes['model_selected_field']) . '</div>
            </div>';
        
        return $select;
    }
}
