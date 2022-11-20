<?php

/**
 * CompanyController.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 13:30
 */

namespace app\controllers;

//use app\core\Application;
use app\core\Controller;
//use app\core\Language;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Company;

/**
 * Description of CompanyController
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\controllers
 * @version 1.0
 */
class CompanyController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['companies']));
    }

    public function getCompanies()
    {
        $result = json_encode(Company::getAll());
        return $result;
    }
    
    public function getCompaniesToSelect()
    {
        $companies = Company::find(['in_select' => 1]);
        return json_encode($companies);
    }
    
    public function getCompany(Request $request, Response $response)
    {
        //$result = new \app\models\RequestResult();
        //$result->start();
        
        $company = new Company();
        if( isset($request->getRouteParams()['id']) )
        {
            $id = (int)$request->getRouteParams()['id'];
            $company = Company::findOne(['id' => $id]);
            //$result->data = Company::findOne(['id' => $id]);
        }
        
        //$result->stop();
        
        //echo '<pre>';
        //var_dump($result);
        //echo '</pre>';
        
        //return json_encode($result);
        return json_encode($company);
    }

    public function create(Request $request, Response $response)
    {
        //
    }
    public function update(Request $request, Response $response)
    {
        //
    }

    public function delete(Request $request, Response $response)
    {
        //
    }
}
