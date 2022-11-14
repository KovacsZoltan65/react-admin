<?php

/**
 * Functions.php
 * User: kzoltan
 * Date: 2022-07-05
 * Time: 09:45
 */

namespace app\core;

/**
 * Description of Functions
 *
 * @author kzoltan
 */
class Functions
{
    /**
     * Bejelentkezett felhasználó azonosítója
     * @return int
     */
    public static function getActualUserId(): int
    {
        return (int)$_SESSION['user'];
    }
    
    /**
     * Megvizsgálja, hogy a kérdéses menüpont az aktuálisan aktív
     * @param string $menu_name
     * @return bool
     */
    public static function is_active_menu(string $menu_name): bool
    {
        return ( trim(basename( filter_input(INPUT_SERVER, 'REQUEST_URI'), '.php' ).PHP_EOL) == $menu_name );
    }
    
    /**
     * Lekéri az aktuálisan aktív nemüpont nevét
     * @return type
     */
    public static function getActiveMenu()
    {
        return trim(basename( filter_input(INPUT_SERVER, 'REQUEST_URI'), '.php' ).PHP_EOL);
    }
    
    /**
     * 
     * @param string $path
     * @return string
     */
    public static function getDirectory (string $path):string
    {
        $retval = '';
        
        $document_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');

        $aa = explode('\\', $document_root);
        
        $retval = "$aa[0]\\$aa[1]\\$aa[2]\\$aa[3]" . $path;
        
        return $retval;
    }
    
    /**
     * 
     * @param string $path
     * @return string
     */
    public static function assets(string $path) : string
    {
        $https = filter_input(INPUT_SERVER, 'HTTPS');
        $http_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $php_self = filter_input(INPUT_SERVER, 'PHP_SELF');
        
        $retval = (isset($https) && $https === 'on' ? 
            'https' : 'http'
        ) . '://' . $http_host . dirname($php_self) . $path;
        
        return $retval;
    }
    
}
