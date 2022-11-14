<?php

/**
 * CompanyController.php
 * User: kzoltan
 * Date: 2022-10-03
 * Time: 13:30
 */

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\User;

/**
 * Description of UserController
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\controllers
 * @version 1.0
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['users']));
    }
    
    /**
     * 
     * @param Request $request
     * @param Response $response
     */
    public function users(Request $request, Response $response)
    {
        $users = User::getAll();
        
        $this->setLayout('main');
        
        return $this->render('users/users', [
            'users' => $users
        ]);
    }
    
    public function user_new(Request $request, Response $response)
    {
        $user = new User();
        
        if( $request->isPost() )
        {
            $user->loadData($request->getBody());
            
            if( $user->validate() && $user->save() )
            {
                Application::$app->session->getFlash('success', 'Thanks for add new user');
                Application::$app->response->redirect('/users');
            }
        }
        $this->setLayout('main');
        return $this->render('users/user_new', [
            'model' => $user,
        ]);
    }
    
    public function user_edit(Request $request, Response $response)
    {
        $user = new User();
        if( isset($request->getRouteParams()['id']) )
        {
            $id = (int)$request->getRouteParams()['id'];
            $user = User::findOne(['id' => $id]);
        }
        
        if( $request->isPost() )
        {
            $user->loadData($request->getBody());
            if( $user->validate() && $user->save() )
            {
                Application::$app->session->setFlash('success', 'Thanks for edit user');
                Application::$app->response->redirect('/users');
            }
        }
        
        $this->setLayout('main');
        return $this->render('users/user_edit', [
            'model' => $user
        ]);
    }
    
    public function user_delete(Request $request, Response $response)
    {
        $user = new User();
        
        if( isset($request->getRouteParams()['id']) )
        {
            $id = (int)$request->getRouteParams()['id'];
            $user = User::findOne(['id' => $id]);
        }
        
        if( $request->isPost() )
        {
            $user->loadData($request->getBody());
            if( $user->validate() && $user->delete() )
            {
                Application::$app->session->setFlash('success', 'Thanks for edit user');
                Application::$app->response->redirect('/users');
            }
        }
        
        $this->setLayout('main');
        return $this->render('users/user_delete', [
            'model' => $user
        ]);
    }
    
    /**
     * Felhasználó adatainak megjelenítése
     * @param Request $request
     * @param Response $response
     */
    public function show(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Új felhasználó adatainak felvitele
     * @param Request $request
     * @param Response $response
     */
    public function create(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Új felhasználó adatinak mentése
     * @param Request $request
     * @param Response $response
     */
    public function store(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Felhasználó adatainak megjelenítése szerkesztésre
     * @param Request $request
     * @param Response $response
     */
    public function edit(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Felhasználó szerkesztett adatainak mentése
     * @param Request $request
     * @param Response $response
     */
    public function update(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Felhasználó adatainak törlése
     * Soft Delete esetén: 
     *  status = 0; 
     *  deleted_at = UTC_TIMESTAMP();
     * @param Request $request
     * @param Response $response
     */
    public function delete(Request $request, Response $response)
    {
        //
    }
}
