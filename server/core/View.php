<?php

/**
 * View.php
 * User: kzoltan
 * Date: 2022-06-26
 * Time: 15:30
 */

namespace app\core;

/**
 * Description of View
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
class View
{
    public string $title = '';
    
    /**
     * Oldal elkészítése
     * @param string $view
     * @param array $params
     * @return type
     */
    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    
    /**
     * Sablon betöltése
     * @version 1.0
     * @return string|bool
     */
    protected function layoutContent()
    {
        // Beállított sablon lekérése
        $layout = Application::$app->layout;
        if( Application::$app->controller )
        {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        
        return ob_get_clean();
    }
    
    /**
     * 
     * @version 1.0
     * @param string $view
     * @param array $params
     * @return string|bool
     */
    protected function renderOnlyView($view, $params)
    {
        foreach($params as $key => $value)
        {
            $$key = $value;
        }
        
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
