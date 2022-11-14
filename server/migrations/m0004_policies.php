<?php

/**
 * m0004_policies.php
 * User: kzoltan
 * Date: 2022-06-20
 * Time: 16:00
 */

/**
 * Description of m0004_policies
 *
 * @author kzoltan
 */
class m0004_policies
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        
        $query = "";
        $db->pdo->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        
        $query = "";
        $db->pdo->exec($query);
    }
}
