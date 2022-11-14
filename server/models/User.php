<?php

/**
 * User.php
 * User: kzoltan
 * Date: 2022-05-18
 * Time: 08:30
 */
namespace app\models;

use app\core\Language;
use app\core\UserModel;

/**
 * Description of User
 * Class User
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\models
 * @version 1.0
 */
class User extends UserModel
{
    public string $email = '',
        $password = '',
        $confirm_password = '',
        $first_name = '',
        $last_name = '',
        $phone_number = '',
        $time_zone = '';
    public int $int = 0,
        $country_id = 0,
        $news_subscription = 0,
        $status = self::STATUS_INACTIVE;
    
    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name'  => [self::RULE_REQUIRED],
            'email'      => [
                self::RULE_REQUIRED, 
                self::RULE_EMAIL,
                [
                    self::RULE_UNIQUE, 
                    'class' => self::class, 
                    'attribute' => 'email'
                ]
            ],
            'password'          => [
                self::RULE_REQUIRED, 
                [self::RULE_MIN, 'min' => 8], 
                [self::RULE_MAX, 'max' => 24]
            ],
            'confirm_password'  => [
                self::RULE_REQUIRED, 
                [self::RULE_MATCH, 'match' => 'password']
            ],
        ];
    }
    
    public function password_change(){
        echo '<pre>';
        print_r('User -> password_change()' . PHP_EOL);
        print_r($this);
        echo '</pre>';
        
        return parent::update();
    }
    
    /**
     * Adattábla neve
     * @return string
     */
    public static function tableName(): string{
        return 'users';
    }

    /**
     * Elsődleges kulcs neve
     * @return string
     */
    public static function primaryKey(): string{
        return 'id';
    }
    
    public function attributes(): array
    {
        return ['first_name','last_name','email','password', 'status'];
    }
    
    /**
     * Címkék
     * @return array
     */
    public function labels(): array
    {
        return [
                  'first_name' => Language::trans('first_name'),
                   'last_name' => Language::trans('last_name'),
                       'email' => Language::trans('email'),
                    'password' => Language::trans('password'),
            'confirm_password' => Language::trans('confirm_password'),
                      'status' => Language::trans('status')
        ];
    }

    /**
     * Felhasználó teljes neve a megjelenítéshez
     * @return string
     */
    public function getDisplayName(): string
    {
        return "$this->first_name $this->last_name";
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'time_zone' => $this->time_zone,
            'country_id' => $this->country_id,
            'news_subscription' => $this->news_subscription,
            'status' => $this->status,
        ];
    }
    
    public function __unserialize(array $data)
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->phone_number = $data['phone_number'];
        $this->time_zone = $data['time_zone'];
        $this->country_id = $data['country_id'];
        $this->news_subscription = $data['news_subscription'];
        $this->status = $data['status'];
    }
    
    public function __toString(): string
    {
        return "$this->id;$this->email;$this->first_name;$this->last_name;$this->phone_number;$this->time_zone;$this->country_id;$this->news_subscription;$this->status";
    }
}
