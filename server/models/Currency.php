<?php

/**
 * Currency.php
 * User: kzoltan
 * Date: 2022-10-05
 * Time: 09:15
 */

namespace app\models;

use app\core\db\DbModel;
use app\core\Language;

/**
 * Description of Currency
 * Class Company
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\models
 * @version 1.0
 */
class Currency extends DbModel
{
    public int $id,
        $currency_decimal,
        $balance_enable,
        $card_payment_enable,
        $invoice_payment_enable,
        $status,
        $in_select = self::INT_FALSE;
    
    public string $currency = '',
        $currency_symbol = '';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function save()
    {
        //
    }
    
    public function insert()
    {
        //
    }
    
    public function update()
    {
        //
    }
    
    //put your code here
    public function attributes(): array
    {
        return [
            'currency',
            'currency_decimal',
            'balance_enable',
            'card_payment_enable',
            'invoice_payment_enable',
            'currency_symbol',
            'in_select','status'
        ];
    }

    /**
     * Szabályok
     * @return array
     */
    public function rules(): array
    {
        return [
            
                          'currency' => [self::RULE_REQUIRED],
                  'currency_decimal' => [self::RULE_REQUIRED],
                    'balance_enable' => [self::RULE_REQUIRED],
               'card_payment_enable' => [self::RULE_REQUIRED],
            'invoice_payment_enable' => [self::RULE_REQUIRED],
                   'currency_symbol' => [self::RULE_REQUIRED],
                         'in_select' => [self::RULE_REQUIRED],
                            'status' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'currency' => Language::trans('currency')
        ];
    }
    
    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'currencies';
    }

    public function __serialize(): array
    {
        return [
            'currency' => $this->currency,
            'currency_decimal' => $this->currency_decimal,
            'balance_enable' => $this->balance_enable,
            'card_payment_enable' => $this->card_payment_enable,
            'invoice_payment_enable' => $this->invoice_payment_enable,
            'currency_symbol' => $this->currency_symbol,
            'status' => $this->status,
        ];
    }
    
    public function __unserialize(array $data): void
    {
        $this->currency = $data['currency'];
        $this->currency_decimal = $data['currency_decimal'];
        $this->balance_enable = $data['balance_enable'];
        $this->card_payment_enable = $data['card_payment_enable'];
        $this->invoice_payment_enable = $data['invoice_payment_enable'];
        $this->currency_symbol = $data['currency_symbol'];
        $this->status = $data['status'];
    }
    
    public function __toString(): string
    {
        return "$this->;$this->currency_decimal;$this->balance_enable;$this->card_payment_enable;$this->invoice_payment_enable;$this->currency_symbol;$this->status;";
    }
}
