<?php

/**
 * ContactForm.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 07:20
 */

namespace app\models;

use app\core\Model;

/**
 * Description of ContactForm
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\models
 * @version 1.0
 */
class ContactForm extends Model
{
    
    public string $subject = '',
        $email = '',
        $body = '';
    
    public function send()
    {
        return true;
    }
    
    /**
     * Szabályok
     * @return array
     */
    public function rules(): array
    {
        return [
            'subject' => [self::RULE_REQUIRED],
            'email'   => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'body'    => [self::RULE_REQUIRED],
        ];
    }
    
    /**
     * Címkék az oldalon
     * @return array
     */
    public function labels(): array
    {
        return [
            'subject' => 'Enter your subject',
            'email' => 'Your email',
            'body' => 'Body',
        ];
    }

}
