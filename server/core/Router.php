<?php
/**
 * Router.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 07:20
 */

namespace app\core;

use app\core\exception\NotFoundException;

/**
 * Class Router
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
class Router
{
    public Request $request;
    public Response $response;
    
    // Útvonalak
	protected array $routeMap = [];

    /**
     * Router constructor
     * @param Request  $request
     * @param Response $response
     */
	public function __construct(Request $request, Response $response)
	{
        $this->request = $request;
        $this->response = $response;
	}

    /**
     * GET kérés regisztrálása
     * @param string $path        Ha a kérés erről a címről jön,
     * @param array $callback    akkor ez fusson le.
     */
	public function get($path, $callback)
	{
		$this->routeMap['get'][$path] = $callback;
	}
    
    /**
     * POST kérés regisztrálása
     * @param string $path     Ha a kérés erről a címről jön,
     * @param array $callback akkor ez fusson le.
     */
    public function post($path, $callback)
	{
		$this->routeMap['post'][$path] = $callback;
	}
    
    public function resolve()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        $callback = $this->routeMap[$method][$url] ?? false;
        
        if (!$callback) 
        {
            $callback = $this->getCallback();
            
            if ($callback === false) 
            {
                throw new NotFoundException();
            }
        }
        
        if (is_string($callback)) 
        {
            return $this->renderView($callback);
        }
        
        if (is_array($callback)) 
        {
            /**
             * @var $controller \thecodeholic\phpmvc\Controller
             */
            $controller = new $callback[0];
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            $middlewares = $controller->getMiddlewares();
            foreach ($middlewares as $middleware) 
            {
                $middleware->execute();
            }
            $callback[0] = $controller;
        }
        
        header('Content-Type: application/json; charset=utf-8;');
        
        header("Access-Control-Allow-Origin: *");
        //header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
        //header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        

        return call_user_func($callback, $this->request, $this->response);
        
//        $path = $this->request->getPath();
//        $method = $this->request->getMethod();
//        $callback = $this->routes[$method][$path] ?? false;
//        
//        if( !$callback )
//        {
//            $callback = $this->getCallback();
//            throw new NotFoundException();
//        }
//        
//        if( is_string($callback) )
//        {
//            return Application::$app->view->renderView($callback);
//        }
//        
//        if( is_array($callback) )
//        {
//            /** @var Controller $controller */
//            
//            $controller = new $callback[0]();
//            Application::$app->controller = $controller;
//            $controller->action = $callback[1];
//            $callback[0] = $controller;
//            
//            foreach( $controller->getMiddlewares() as $middleware )
//            {
//                $middleware->execute();
//            }
//        }
//        
//        return call_user_func($callback, $this->request, $this->response);
        
    }
    
    public function getCallback()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        
        // Trim slashes
        $url = trim($url, '/');
        
        // Get all routes for current request method
        $routes = $this->routeMap[$method] ?? [];
        
        $routeParams = false;
        
        // Start iterating registed routes
        foreach( $routes as $route => $callback )
        {
            // Trim slashes
            $route = trim($route, '/');
            $routeNames = [];
            
            if( !$route )
            {
                continue;
            }
            
            // /login/{id}
            // /profile/{id:\d+}/{username}
            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) 
            {
                $routeNames = $matches[1];
            }
            
            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";
            
            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) 
            {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) 
                {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }
        return false;
    }
    
    public function renderContent($viewContent)
    {
        //return Application::$app->view->renderContent($viewContent);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    
    public function renderView($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function renderViewOnly($view, $params = [])
    {
        return Application::$app->view->renderViewOnly($view, $params);
    }
}