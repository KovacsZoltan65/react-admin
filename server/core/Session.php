<?php

/**
 * Session.php
 * User: kzoltan
 * Date: 2022-06-22
 * Time: 12:50
 */

namespace app\core;

/**
 * Description of Session
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        
        foreach($flashMessages as $key => &$flashMessage)
        {
            $flashMessage['remove'] = true;
        }
        
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
    
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }
    
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
    
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message,
        ];
    }
    
    public function getFlash($key)
    {
        return $_SESSION['flash_messages'][$key]['value'] ?? false;
    }
    
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        
        foreach($flashMessages as $key => &$flashMessage)
        {
            if($flashMessage['remove'])
            {
                unset($flashMessages[$key]);
            }
        }
        
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
