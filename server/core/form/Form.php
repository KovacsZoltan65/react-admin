<?php

/**
 * Form.php
 * User: kzoltan
 * Date: 2022-05-18
 * Time: 13:20
 */

namespace app\core\form;

use app\core\Model;

/**
 * Description of Form
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */
class Form
{
    /**
     * Űrlap kezdete
     * @param string $action
     * @param string $method
     * @return object
     */
    public static function begin(string $action, string $method): object
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }
    
    /**
     * Űrlap vége
     */
    public static function end()
    {
        //echo '</form>';
        return '</form>';
    }
    
    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}
