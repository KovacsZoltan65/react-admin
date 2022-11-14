<?php

/**
 * Language.php
 * User: kzoltan
 * Date: 2022-10-04
 * Time: 07:25
 */

namespace app\core;

/**
 * Description of Language
 *
 * @author kzoltan
 */
class Language
{
    public static function trans(string $word) : string
    {
        $retval = '';
        
        $lang = Config::get('lang');
        
        $file = Functions::getDirectory("/lang/{$lang}.json");
         
        $json_trans = (string)file_get_contents($file);
        $arr_trans = json_decode($json_trans, true);
        $path = explode('\\', str_replace('/', '\\', $word));
        
        foreach( $path as $bit )
        {
            if( isset($arr_trans[$bit]) ){ $retval = $arr_trans[$bit]; }
            else                         { $retval = $bit; }
        }
        
        return $retval;
    }
    
    public static function load(string $lang) : void
    {
        //
    }
    
}
