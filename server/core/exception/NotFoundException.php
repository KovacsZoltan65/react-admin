<?php

/**
 * ForbiccenException.php
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
class NotFoundException extends \Exception
{
    protected $message = "Page not found.";
    protected $code = 404;
}
