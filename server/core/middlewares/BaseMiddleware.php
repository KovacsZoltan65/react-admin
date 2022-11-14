<?php

/**
 * BaseMiddleware.php
 * User: kzoltan
 * Date: 2022-06-26
 * Time: 12:30
 */

namespace app\core\middlewares;

/**
 * Description of BaseMiddleware
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\middlewares
 * @version 1.0
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}
