<?php

/**
 * AuthMiddleware.php
 * User: kzoltan
 * Date: 2022-06-26
 * Time: 13:30
 */

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;

/**
 * Description of AuthMiddleware
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\middlewares
 * @version 1.0
 */
class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];
    
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }
    
    //put your code here
    public function execute()
    {
        if( Application::isGuest() )
        {
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions))
            {
                throw new ForbiddenException();
            }
        }
    }

}
