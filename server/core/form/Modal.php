<?php

/**
 * Modal.php
 * User: kzoltan
 * Date: 2022-10-07
 * Time: 08:25
 */

namespace app\core\form;



/**
 * Description of Modal
 * Class Button
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */
class Modal
{
    const TYPE_DELETE = 'delete',
        TYPE_EDIT = 'edit';
    public $type = self::TYPE_EDIT;
    
    public array $attributes = [];
    
    public function __construct(array $attributes)
    {
        $this->type = self::TYPE_EDIT;
        $this->attributes = $attributes;
    }
    
    public function __toString()
    {
        $name = ( !isset($this->attributes['name']) || $this->attributes['name'] == '' ) 
            ? $this->attributes['id'] 
            : $this->attributes['name'];
        
        switch ($this->type) {
            case self::TYPE_EDIT:
                break;
            case self::TYPE_DELETE:
                break;
            default:
                break;
        }
        
        $modal = 
            '<div class="modal fade" 
                  id="' . $this->attributes['id'] . '" 
                  name="' . $name . '" 
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="modal_label" 
                  aria-hidden="true">
                  
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                
                    <div class="modal-content">
                  
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal_label">' . $this->attributes['modal_title'] . '</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="' . $this->attributes['form_action'] . '" method="' . $this->attributes['form_method'] . '">
                            <div class="modal-body">
                              ' . $this->attributes['modal_body'] . '
                            </div>

                            <div class="modal-footer">' 
                                . (new Button($this->attributes['modal_cancel_button']))->button() 
                                . (new Button($this->attributes['modal_function_button']))->submit() . '
                            </div>
                        </form>
                    </div>
                </div>
            </div>';
        
        return $modal;
    }
    
    public function edit()
    {
        $this->type = self::TYPE_EDIT;
        return $this;
    }
    
    public function delete()
    {
        $this->type = self::TYPE_DELETE;
        return $this;
    }
    
}
?>
