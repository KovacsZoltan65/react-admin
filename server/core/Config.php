<?php

/**
 * Config.php
 * User: kzoltan
 * Date: 2022-10-03
 * Time: 14:35
 */

namespace app\core;

/**
 * Description of Config
 *
 * @author kzoltan
 */
class Config
{
    public static function get($path = null)
    {
        if( $path )
        {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            
            foreach($path as $bit)
            {
                if( isset($config[$bit]) )
                {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return $false;
    }
}
