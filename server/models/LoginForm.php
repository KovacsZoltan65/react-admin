<?php

/**
 * LoginModel.php
 * User: kzoltan
 * Date: 2022-05-20
 * Time: 07:30
 */

namespace app\models;

use app\core\Application;
use app\core\Language;
use app\core\Model;

/**
 * Description of LoginModel
 * Class LoginForm
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\models
 * @version 1.0
 */
class LoginForm extends Model
{
    public string $email = '', 
        $password = '';
    
    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Beléptetés
     * @return boolean
     */
    public function login()
    {
        // Felhasználó lekérése email alapján
        $user = User::findOne(['email' => $this->email]);
        
        // Ha megtalálja a keresett felhasználót, akkor...
        if( !$user )
        {
            // Hibaüzenet bejegyzése
            $this->addError('email', 'User does not exist with this email');
            return false;
        }
        // Jelszó ellenőrzése
        if( !password_verify($this->password, $user->password) )
        {
            // Hibaüzenet bejegyzése
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        
        // Belépés idejének regisztrálása
        //$user->last_login = 'UTC_TIMESTAMP()';
        //$user->update();
        
        // Beléptetés utáni műveletek
        return Application::$app->login($user);
    }
    
    /**
     * Szabályok
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'    => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }
    
    /**
     * Oldal feliratai
     * @return array
     */
    public function labels(): array
    {
        return [
            'email' => Language::trans('your email'),
            'password' => Language::trans('password'),
        ];
    }
    
}
