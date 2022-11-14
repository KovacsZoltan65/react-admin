<?php

/**
 * login.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 7:18
 */

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Form;
use app\core\Language;

/** @var \app\models\User $model */
/** @var \app\core\View $this */

$this->title = $title;

?>

<h1><?php echo $this->title; ?></h1>

<div class="card">
    
    <div class="card-header"><?php echo $this->title; ?></div>
    
<?php $form = Form::begin('', 'post'); ?>
    
    <div class="card-body">
<?php 
// --------------
// Dolgozó neve
// --------------
echo $form->field($model, 'email');
echo $form->field($model, 'password')->passwordField();
?>

    </div>
    
    <div class="card-footer">
<?php
// ----------------------------
// "Regisztráció" gomb
// ----------------------------
echo (new Anchor([
       'id' => 'btn_cancel',
    'class' => 'btn btn-info',
     'href' => '/register',
    'title' => $register_title
]));
// ----------------------------
// "Mentés" gomb
// ----------------------------
echo (new Button([
       'id' => 'btn',
    'class' => 'btn btn-primary float-right',
    'style' => 'margin-right: 5px;margin-left: 5px;',
    'title' => $login_title
]))->submit();
?>
    </div>
<?php Form::end(); ?>
</div>