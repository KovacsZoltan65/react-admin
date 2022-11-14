<?php

/**
 * SiteController.php
 * User: kzoltan
 * Date: 2022-05-17
 * Time: 07:30
 */

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

/**
 * Class SiteController
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\controllers
 * @version 1.0
 */
class SiteController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['contact']));
    }
    /**
     * 
     * @return type
     */
    public function home()
    {
        $params = [
            'name' => 'TheCodeholic',
        ];
        return $this->render('home', $params);
    }
    
    /**
     * Kontakt oldal kezelése
     * @param Request $request
     * @param Response $response
     * @return type
     */
    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();
        if( $request->isPost() )
        {
            $contact->loadData($request->getBody());
            if( $contact->validate() && $contact->send() )
            {
                Application::$app->session->setFlash('success', 'Thanks for contacting us.');
                return $response->redirect('/contact');
            }
        }
        return $this->render('contact', [
            'model' => $contact
        ]);
    }
    
}
