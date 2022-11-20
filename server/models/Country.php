<?php

/**
 * Country.php
 * User: kzoltan
 * Date: 2022-10-10
 * Time: 13:55
 */

namespace app\models;

use app\core\db\DbModel;

/**
 * Description of Country
 *
 * @author kzoltan
 */
class Country extends DbModel
{
    public int $id = 0,
        $vat_region = 0,
        $in_select = self::INT_FALSE,
        $status = self::STATUS_ACTIVE;
    public string $lang_hu = '',
        $lang_orig = '',
        $country_hu = '',
        $country_orig = '',
        $country_short = '',
        $currency = '';

    public function __construct()
    {
        parent::__construct();
    }

    //put your code here
    public function attributes(): array
    {
        return ['lang_hu','lang_orig','country_hu','country_orig','country_short','currency','vat_region','in_select','status'];
    }

    public function rules(): array
    {
        return [
                  'lang_hu' => [self::RULE_REQUIRED],
                'lang_orig' => [self::RULE_REQUIRED],
               'country_hu' => [self::RULE_REQUIRED],
             'country_orig' => [self::RULE_REQUIRED],
            'country_short' => [self::RULE_REQUIRED],
                 'currency' => [self::RULE_REQUIRED],
               'vat_region' => [self::RULE_REQUIRED],
                'in_select' => [self::RULE_REQUIRED],
                   'status' => [self::RULE_REQUIRED],
        ];
    }

    /**
     * Címkék
     * @return array
     */
    public function labels(): array
    {
        return [
                  'lang_hu' => 'lang hu',
                'lang_orig' => 'lang orig',
               'country_hu' => 'country hu',
             'country_orig' => 'country orig',
            'country_short' => 'country short',
                 'currency' => 'currency',
               'vat_region' => 'vet region',
                'in_select' => 'in select',
                   'status' => 'status',
        ];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'countries';
    }

    public function __serialize(): array
    {
        return [
                       'id' => $this->id,
               'country_hu' => $this->country_hu,
             'country_orig' => $this->country_orig,
            'country_short' => $this->country_short,
                 'currency' => $this->currency,
                  'lang_hu' => $this->lang_hu,
                'lang_orig' => $this->lang_orig,
               'vat_region' => $this->vat_region,
                'in_select' => $this->in_select,
                   'status' => $this->status,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->country_hu = $data['country_hu'];
        $this->country_orig = $data['country_orig'];
        $this->country_short = $data['country_short'];
        $this->currency = $data['currency'];
        $this->lang_hu = $data['lang_hu'];
        $this->lang_orig = $data['lang_orig'];
        $this->vat_region = $data['vat_region'];
        $this->in_select = $data['in_select'];
        $this->status = $data['status'];
    }

    public function __toString(): string
    {
        return "$this->id;$this->lang_hu;$this->lang_orig;$this->country_hu;$this->country_orig;$this->country_short;$this->currency;$this->vat_region;$this->in_select;$this->status";
    }
}
