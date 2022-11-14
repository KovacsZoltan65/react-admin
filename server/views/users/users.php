<?php

use app\core\form\Anchor;
use app\core\Language;

/**
 * users.php
 * User: kzoltan
 * Date: 2022-10-03
 * Time: 13:45
 */

$this->title = Language::trans('users');

?>

<h1><?php echo $this->title; ?></h1>

<div>
<!--
    <a id="btn_new" name="btn_new" 
       href="user_new" 
       type="button" 
       class="btn btn-primary">Add New</a>
-->
<?php
echo (new Anchor([
    'id' => 'btn_new',
    'class' => 'btn btn-primary',
    'href' => 'user_new',
    'title' => Language::trans('add new'),
]));
?>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo Language::trans('name'); ?></th>
            <th><?php echo Language::trans('functions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo "$user->last_name $user->first_name"; ?></td>
            <td>
                <!--
                <a href="user_edit/<?php //echo $user->id; ?>" 
                   type="button" class="btn btn-primary" 
                   id="btn_edit" name="btn_edit" >
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="user_delete/<?php //echo $user->id; ?>" 
                   id="btn_delete" name="btn_delete" 
                   type="button" class="btn btn-danger">
                    <i class="bi bi-trash"></i>
                </a>
                -->
<?php
echo (new Anchor([
    'id' => 'btn_edit',
    'class' => 'btn btn-primary',
    'href' => 'user_edit/' . $user->id,
    'icon' => 'bi bi-pencil',
]));

echo (new Anchor([
    'id' => 'btn_delete',
    'class' => 'btn btn btn-danger',
    'href' => 'user_delete/' . $user->id,
    'icon' => 'bi bi-trash',
]));
?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>