<?php

/**
 * Response.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 07:20
 */

namespace app\core;

/**
 * Class Response
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
class Response
{
    /**
     * 
     * @param int $code
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }
    
    /**
     * Kérés átirányítása
     * @param string $url
     */
    public function redirect(string $url)
    {
        header("Location: $url");
    }
}