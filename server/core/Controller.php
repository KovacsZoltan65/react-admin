<?php

/**
 * Controller.php
 * User: kzoltan
 * Date: 2022-05-17
 * Time: 07:50
 */

namespace app\core;

use app\core\middlewares\BaseMiddleware;

/**
 * Class Controller
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
class Controller
{
    public string $layout = 'main', 
        $action = '';
    
    /**
     * 
     * @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];
    
    /**
     * Keret beállítása
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }
    
    /**
     * Köztes réteg regisztrálása
     * @param BaseMiddleware $middleware
     */
    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
    
    /**
     * Regisztrált köztes rétegek lekérése
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
