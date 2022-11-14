<?php

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Form;
use app\core\Language;

/**
 * register.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 07:20
 */
/** @var $model \app\models\User */

/** @var $this \app\core\View */
$this->title = Language::trans('register');

?>

<h1><?php echo $this->title; ?></h1>
<?php $form = Form::begin('', 'post'); ?>
<div class="card">
    
    <div class="card-header"><?php echo $this->title; ?></div>
    <div class="card-body">
        
        <div class="row">
            <div class="col">
                <?php 
                // ----------------------------
                // Vezetéknév
                // ----------------------------
                echo $form->field($model, 'first_name'); 
                ?>
            </div>
            <div class="col">
                <?php 
                // ----------------------------
                // Keresztnév
                // ----------------------------
                echo $form->field($model, 'last_name'); 
                ?>
            </div>
        </div>
        
<?php
// ----------------------------
// Email
// ----------------------------
echo $form->field($model, 'email'); 

// ----------------------------
// Jelszó
// ----------------------------
echo $form->field($model, 'password'); 

// ----------------------------
// Jelszó ismét
// ----------------------------
echo $form->field($model, 'confirm_password');
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
     'href' => '/login',
    'title' => $login_title
]));
// ----------------------------
// "Mentés" gomb
// ----------------------------
echo (new Button([
       'id' => 'btn',
    'class' => 'btn btn-primary float-right',
    'style' => 'margin-right: 5px;margin-left: 5px;',
    'title' => $register_title
]))->submit();
?>
    </div>
<?php echo Form::end(); ?>
</div>

<?php /*$form = Form::begin('', 'post'); ?>
<div class="row">
    <div class="col">
        <?php 
        // ----------------------------
        // Vezetéknév
        // ----------------------------
        echo $form->field($model, 'first_name'); 
        ?>
    </div>
    <div class="col">
        <?php 
        // ----------------------------
        // Keresztnév
        // ----------------------------
        echo $form->field($model, 'last_name'); 
        ?>
    </div>
</div>
<?php 
// ----------------------------
// Email
// ----------------------------
echo $form->field($model, 'email'); 

// ----------------------------
// Jelszó
// ----------------------------
echo $form->field($model, 'password'); 

// ----------------------------
// Jelszó ismét
// ----------------------------
echo $form->field($model, 'confirm_password'); 

echo (new Button([
    'id' => 'btn',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'title' => Language::trans('create')
]))->submit();

echo Form::end(); 
*/?>
<?php /* ?>
<form action="" method="post">
    
    <div class="row">
<?php $arr = $model->getClasses('last_name'); ?>
        <div class="col">
            <div class="form-group">
                <label for="subject">Vezetéknév</label>
                <input value="<?php echo $model->last_name; ?>" 
                       class="form-control<?php echo $arr['class_1']; ?>" 
                       id="last_name" name="last_name" type="text"
                       aria-describedby="last_nameHelp">
                <div id="last_nameHelp" name="last_nameHelp" 
                     class="<?php echo $arr['class_2']; ?>"
                     ><?php echo $model->getFirstError('last_name'); ?></div>
            </div>
        </div>
<?php
// ----------------------------
// Keresztnév
// ----------------------------
$arr = $model->getClasses('first_name');
?>
        <div class="col">
            <div class="form-group">
                <label for="first_name">Keresztnév</label>
                <input value="<?php echo $model->first_name; ?>" 
                       type="text" 
                       class="form-control<?php echo $arr['class_1']; ?>" 
                       id="first_name" name="first_name" 
                       aria-describedby="first_nameHelp">
                <div id="first_nameHelp" name="first_nameHelp" 
                     class="<?php echo $arr['class_2']; ?>"
                     ><?php echo $model->getFirstError('first_name'); ?></div>
            </div>
        </div>
    </div>
<?php
// ----------------------------
// Email cím
// ----------------------------
$arr = $model->getClasses('email');
?>
    <div class="form-group">
        <label for="email">Email cím</label>
        <input value="<?php echo $model->email; ?>"
               type="email" 
               class="form-control<?php echo $arr['class_1']; ?>" 
               id="email" name="email" 
               aria-describedby="emailHelp">
        <div id="emailHelp" name="emailHelp" 
             class="<?php echo $arr['class_2']; ?>"
             ><?php echo $model->getFirstError('email'); ?></div>
    </div>
<?php
// ----------------------------
// Jelszó
// ----------------------------
$arr = $model->getClasses('password');
?>
    <div class="form-group">
        <label for="body">Jelszó</label>
        <input value="<?php echo $model->password; ?>"
               type="password" 
               class="form-control<?php echo $arr['class_1']; ?>" 
               id="password" name="password"
               aria-describedby="passwordHelp"/>
        <div id="passwordHelp" name="passwordHelp" 
             class="<?php echo $arr['class_2']; ?>"
             ><?php echo $model->getFirstError('password'); ?></div>
    </div>
<?php
// ----------------------------
// Jelszó ismét
// ----------------------------
$arr = $model->getClasses('confirm_password');
?>
    <div class="form-group">
        <label for="body">Jelszó ismét</label>
        <input value="<?php echo $model->confirm_password; ?>"
               type="password" 
               class="form-control<?php echo $arr['class_1']; ?>" 
               id="confirm_password" name="confirm_password"
               aria-describedby="confirm_passwordHelp"/>
        <div id="confirm_passwordHelp" name="confirm_passwordHelp" 
             class="<?php echo $arr['class_2']; ?>"
             ><?php echo $model->getFirstError('confirm_password'); ?></div>
    </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php */ ?>