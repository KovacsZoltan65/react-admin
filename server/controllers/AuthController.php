<?php

/**
 * AuthController.php
 * User: kzoltan
 * Date: 2022-05-17
 * Time: 07:30
 */

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Language;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;


/**
 * Class AuthController
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\controllers
 * @version 1.0
 */
class AuthController extends Controller
{
    /**
     * Konstruktor
     */
    public function __construct()
    {
        // Autentákíciós középréteg registrálása
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    
    /**
     * Belépés kezelése
     * GET kérés esetén a login oldal betöltése,
     * POST kérés esetén beléptetés
     * @param Request $request
     * @param Response $response
     * @return type
     */
    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if($request->isPost())
        {
            $loginForm->loadData($request->getBody());
            
            if( $loginForm->validate() && $loginForm->login() )
            {
                //$loginModel->login_logging();
                $response->redirect('/');
                return;
            }
        }
        
        $this->setLayout('auth');
        $login_title = Language::trans('login');
        return $this->render('login', [
                     'title' => $login_title,
               'login_title' => $login_title,
            'register_title' => Language::trans('register'),
                     'model' => $loginForm,
        ]);
    }
   
    /**
     * Regisztráció kezelése
     * GET kérés esetén regisztrációs oldal betöltése
     * POST kérés esetén regisztráció
     * @param Request $request
     * @return string
     */
    public function register(Request $request)
    {
        $user = new User();
        
        if($request->isPost())
        {
            $user->loadData($request->getBody());
            
            if( $user->validate() && $user->save() )
            {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
            }
            
            return $this->render('register', [
                'model' => $user,
            ]);
        }
        
        $register_title = Language::trans('register');
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user,
            'title' => $register_title,
            'register_title' => $register_title,
            'login_title' => Language::trans('login'),
        ]);
    }
    
    public function change_password(Request $request, Response $response)
    {
        $user = new User();
        
        if( $request->isPost() )
        {
            $body = $request->getBody();
            
            $id = $body['change_id'];
            $user = (new User())->findOne(['id' => $id]);
            
            echo '<pre>';
            print_r('AuthController() -> change_password' . PHP_EOL);
            var_dump($user);
            echo '</pre>';
            
            //$user->password = $body['password'];
            //$user->confirm_password = $body['confirm_password'];
            
            $user->password_change();
            
            //$user->password_change();
        }
        
    }
    
    /**
     * Kilépés kezelése
     * @param Request $request
     * @param Response $response
     */
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
    
    /**
     * Profil oldal betöltése
     * @return type
     */
    public function profile(Request $request, Response $response)
    {
        $user = User::findOne(['id' => Application::$app->session->get('user')]);
        
        if( $request->isPost() )
        {
            //
        }
        
        $change_title = Language::trans('change_password');
        
        return $this->render('profile', [
            'user' => $user,
            'title' => Language::trans('profile'),
            'change_title' => $change_title,
            'cancel' => Language::trans('cancel'),
            'save' => Language::trans('save'),
            'change' => Language::trans('change'),
            'change_password' => $change_title,
        ]);
    }
}
