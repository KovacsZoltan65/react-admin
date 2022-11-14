<?php

/**
 * UserModel.php
 * User: kzoltan
 * Date: 2022-06-23
 * Time: 09:00
 */

namespace app\core;

use app\core\db\DbModel;

/**
 * Description of UserModel
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core
 * @version 1.0
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
