<?php

/**
 * Request.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 07:20
 */

namespace app\core;

/**
 * Class Request
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
class Request
{
    private array $routeParams = [];
    
    /**
     * Bejövő kérés útvonalának lekérése
     * @return string
     */
    public function getUrl()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        
        if( $position === false )
        {
            return $path;
        }
        
        return substr($path, 0, $position);
        
    }
    
    /**
     * Bejövő kérés típusának megállapítása
     * @return type
     */
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    
    /**
     * A bejövő kérés vizsgálata (get)
     * @return bool
     */
    public function isGet()
    {
        return  $this->getMethod() === 'get';
    }
    
    /**
     * A bejövő kérés vizsgálata (post)
     * @return bool
     */
    public function isPost()
    {
        return  $this->getMethod() === 'post';
    }
    
    /**
     * A kéréssel jövő adatok összegyűjtése
     * @return array
     */
    public function getBody(): array
    {
        $body = [];
        $arr = [];
        
        if( $this->isGet() )
        {
            foreach($_GET as $key => $value)
            {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        
        if( $this->isPost() )
        {
            if( count($_POST) > 0 )
            {
                foreach($_POST as $key => $value)
                {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            else
            {
                $request = json_decode(file_get_contents('php://input'), true);
                foreach($request as $key => $value)
                {
                    $body[$key] = $value;
                }
            }
        }
        
        return $body;
    }
    
    public function setRouteParams($params)
    {
        $this->routeParams = $params;
        return $this;
    }
    
    public function getRouteParams()
    {
        return $this->routeParams;
    }
}
