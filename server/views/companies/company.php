<?php

use app\core\form\Button;
use app\core\form\Form;
use app\core\Language;

/**
 * company.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 07:15
 */

$this->title = Language::trans('company');

?>

<h1>Company</h1>

<?php $form = Form::begin('', 'post'); ?>

<?php
// ----------------------------
// Cég neve
// ----------------------------
echo $form->field($model, 'name');
?>

<?php 
echo new (Button(['id' => 'btn_save','name' => '','class' => '','title' => Language::trans('save'),]))->submit();
Form::end(); 
?>