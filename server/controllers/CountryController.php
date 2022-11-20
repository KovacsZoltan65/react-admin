<?php

/**
 * CountryController.php
 * User: kzoltan
 * Date: 2022-10-10
 * Time: 13:45
 */

namespace app\controllers;

use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Country;

/**
 * Description of CountryController
 *
 * @author kzoltan
 */
class CountryController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['countries']));
    }
    
    public function getCountries()
    {
        $result = json_encode(Country::getAll());
        return $result;
    }
    
    public function getCountriesToSelect()
    {
        $countries = Country::find(['in_select' => 1]);
        
        usort($countries, fn($a, $b) => strcmp($a->country_hu, $b->country_hu));
        
        return $countries;
    }
    
    public function getCountry(Request $request, Response $response)
    {
        $country = new Country();
        if( isset($request->getRouteParams()['id']) )
        {
            $id = (int)$request->getRouteParams()['id'];
            $country = Country::findOne(['id' => $id]);
        }
        
        return json_encode($country);
    }
    
    public function country_new(Request $request, Response $response)
    {
        //
    }
    
    public function country_edit(Request $request, Response $response)
    {
        //
    }
    
    public function country_delete(Request $request, Response $response)
    {
        //
    }
}
