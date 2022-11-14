<?php

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Form;

/**
 * profile.php
 * User: kzoltan
 * Date: 2022-06-26
 * Time: 11:45
 */

/** @var $this \app\core\View */
$this->title = $title;

?>

<h1><?php echo $title; ?></h1>

<div class="card">
    
    <div class="card-header"><?php echo $title; ?></div>
<?php
$form = Form::begin('', 'post');
?>
    <div class="card-body">
        <input type="hidden" id="id" name="id" value="<?php echo $user->id; ?>"/>
<?php
echo $form->field($user, 'email');
?>
        
        <div class="row">
            <div class="col">
<?php
echo $form->field($user, 'first_name');
?>
            </div>
            <div class="col">
<?php
echo $form->field($user, 'last_name');
?>
            </div>
        </div>
        
    </div>
    
    <div class="card-footer">
<?php
// ----------------------------
// "Mégsem" gomb
// ----------------------------
echo (new Anchor([
    'id' => 'btn_cancel',
    'class' => 'btn btn-info',
    'href' => '/',
    'title' => $cancel
]));

// ----------------------------
// "Mentés" gomb
// ----------------------------
echo (new Button([
    'id' => 'btn',
    'class' => 'btn btn-primary float-right',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'title' => $save
]))->submit();
?>
    </div>
<?php echo Form::end(); ?>
</div>

<div class="dropdown-divider"></div>

<div class="card">
    
    <div class="card-header"><?php echo $change_title; ?></div>
<?php $form = Form::begin('change_password', 'post'); ?>
    <div class="card-body">
        
        <input type="hidden" 
               id="change_id" 
               name="change_id" 
               value="<?php echo $user->id; ?>"/>
        
        <div class="row">
            <div class="col border-right">

                <div class="form-group">
                    <label for="password">Jelszó</label>
                    <input type="text" 
                           class="form-control" 
                           id="password" name="password"
                           aria-describedby="passwordHelp">
                    <small id="passwordHelp" 
                           class="form-text text-muted"
                    >We'll never share your email with anyone else.</small>
                </div>
                
            </div>
            <div class="col">

                <div class="form-group">
                    <label for="confirm_password">Megerősítés</label>
                    <input type="text" 
                           class="form-control" 
                           id="confirm_password" name="confirm_password"
                           aria-describedby="confirm_passwordHelp">
                    <small id="confirm_passwordHelp" 
                           class="form-text text-muted"
                    >We'll never share your email with anyone else.</small>
                </div>
                
            </div>
        </div>
        
    </div>
    
    <div class="card-footer">
<?php
// ----------------------------
// "Módosítás" gomb
// ----------------------------
echo (new Button([
    'id' => 'btn',
    'class' => 'btn btn-primary',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'title' => $change
]))->submit();
?>
    </div>
<?php echo Form::end(); ?>
</div>