<?php

/**
 * Human.php
 * User: kzoltan
 * Date: 2022-10-20
 * Time: 13:15
 */

namespace app\models;

use app\core\db\DbModel;
use app\core\Language;

/**
 * Description of Human
 *
 * @author kzoltan
 */
class Human extends DbModel
{
    public int $id = 0,
        $company_id = 0,
        $country_id = 0,
        $status = 0;
    public string $name = '';

    /**
     * Cellanevek
     * @return array
     */
    public function attributes(): array
    {
        return ['id','name','company_id','country_id','lang_id','status'];
    }

    /**
     * Szabályok
     * @return array
     */
    public function rules(): array
    {
        return [
                  'name' => [self::RULE_REQUIRED],
            'company_id' => [self::RULE_REQUIRED],
            'country_id' => [self::RULE_REQUIRED],
        ];
    }

    /**
     * Címkék
     * @return array
     */
    public function labels(): array
    {
        return [
            'name' => Language::trans('name'),
            'company_id' => Language::trans('company'),
            'country_id' => Language::trans('country'),
        ];
    }

    /**
     * Adatbázis elsődleges kulcsmező neve
     * @return string
     */
    public static function primaryKey(): string
    {
        return 'id';
    }

    /**
     * Adatbázis táblanév
     * @return string
     */
    public static function tableName(): string
    {
        return 'humans';
    }

    /**
     *
     * @return array
     */
    public function __serialize(): array
    {
        return [
                    'id' => $this->id,
                  'name' => $this->name,
            'company_id' => $this->company_id,
            'country_id' => $this->country_id,
                'status' => $this->status,
        ];
    }

    /**
     *
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
                $this->id = $data['id'];
              $this->name = $data['name'];
        $this->company_id = $data['company_id'];
        $this->country_id = $data['country_id'];
            $this->status = $data['status'];
    }
    public function __toString(): string
    {
        return "$this->id;$this->name;$this->company_id;$this->country_id;$this->status";
    }
}
