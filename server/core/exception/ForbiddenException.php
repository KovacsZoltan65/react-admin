<?php

/**
 * NotFoundException.php
 * User: kzoltan
 * Date: 2022-06-26
 * Time: 13:30
 */

namespace app\core\exception;

/**
 * Description of ForbiddenException
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\exception
 * @version 1.0
 */
class ForbiddenException extends \Exception
{
    protected $message = "You don~t have permission to access this page.";
    protected $code = 403;
    
}
