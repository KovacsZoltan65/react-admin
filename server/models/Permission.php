<?php

/**
 * Permission.php
 * User: kzoltan
 * Date: 2022-10-21
 * Time: 10:15
 */

namespace app\models;

/**
 * Description of Permission
 *
 * @author kzoltan
 */
class Permission extends \app\core\db\DbModel
{
    public int $id,
        $status;
    public string $name,
        $comment;
    
    //put your code here
    public function attributes(): array {
        
    }

    public function rules(): array {
        
    }

    public static function primaryKey(): string {
        
    }

    public static function tableName(): string {
        
    }

    public function __construct()
    {
        parent::__construct();
    }
    
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'comment' => $this->comment,
            'status' => $this->status,
        ];
    }
    public function __unserialize(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->comment = $data['comment'];
        $this->status = $data['status'];
    }
    public function __toString(): string
    {
        return "$this->id;$this->name;$this->comment;$this->status";
    }
}
