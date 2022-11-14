<?php

/**
 * CurrencyController.php
 * User: kzoltan
 * Date: 2022-10-05
 * Time: 10:05
 */

namespace app\controllers;

use app\core\Controller;
use app\core\Language;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Currency;

/**
 * Description of CurrencyController
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\controllers
 * @version 1.0
 */
class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['currencies']));
    }
    
    public function getCurrenciesToSelect()
    {
        $currencies = Currency::find(['in_select' => 1]);
        
        //usort($currencies, fn($a, $b) => strcmp($a->currency, $b->currency));
        usort($currencies, function($a, $b){ return strcmp($a->currency, $b->currency); });
        
        return $currencies;
    }
    
    public function currencies(Request $request, Response $response)
    {
        $currencies = Currency::getAll();
        
        $this->setLayout('main');
        return $this->render('currencies/currencies', [
            'currencies' => $currencies,
            'title' => Language::trans('currencies'),
            ]);
    }
    
    public function currency_new(Request $request, Response $response)
    {
        //
    }
    
    public function currency_edit(Request $request, Response $response)
    {
        //
    }
    
    public function currency_delete(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Pénznem adatainak megjelenítése
     * @param Request $request
     * @param Response $response
     */
    public function show(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Új Pénznem adatainak felvitele
     * @param Request $request
     * @param Response $response
     */
    public function create(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Új Pénznem adatinak mentése
     * @param Request $request
     * @param Response $response
     */
    public function store(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Pénznem adatainak megjelenítése szerkesztésre
     * @param Request $request
     * @param Response $response
     */
    public function edit(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Pénznem szerkesztett adatainak mentése
     * @param Request $request
     * @param Response $response
     */
    public function update(Request $request, Response $response)
    {
        //
    }
    
    /**
     * Pénznem adatainak törlése
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
