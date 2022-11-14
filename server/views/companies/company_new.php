<?php

/**
* company_new.php
* User: kzoltan
* Date: 2022-07-05
* Time: 08:30
*/

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Form;
use app\core\form\Select;
use app\core\Language;
use app\models\Company;

/** @var Company $company */
/** @var array<Country> $countries */
/** @var array<Currency> $currencies */

$this->title = $title;

?>

<h1><?php echo $this->title; ?></h1>

<div class="card">
    
    <div class="card-header"><?php echo $this->title; ?></div>
    
<?php $form = Form::begin('', 'post'); ?>
    <div class="card-body">
<?php

// ----------------------------
// Cég azonosító
// ----------------------------
echo $form->field($company, "id")->hiddenField();

// ----------------------------
// Cég neve
// ----------------------------
echo $form->field($company, 'name');

?>
        <div class="row">
            
            <div class="col border-right">
<?php
// ----------------------------
// Ország
// ----------------------------
echo (new Select($company, [
    'id' => 'country_id',
    'name' => 'country_id',
    'class' => 'form-control',
    'title' => 'country',
    'value_field' => 'id',
    'selected_field' => 'id',
    'model_selected_field' => 'id',
    'title_field' => 'country_hu',
    'blank_row' => true,
    'data' => $countries,
] ));
?>
            </div>
            
            <div class="col">
<?php
// ----------------------------
// Pénznem
// ----------------------------
//$currencies = (new CurrencyController)->getCurrenciesToSelect();
echo (new Select($company, [
    'id' => 'currency',
    'name' => 'currency',
    'class' => 'form-control',
    'title' => 'currency',
    'value_field' => 'currency',
    'selected_field' => 'currency',
    'model_selected_field' => 'currency',
    'title_field' => 'currency',
    'blank_row' => true,
    'data' => $currencies,
] ));
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
    'href' => '/companies',
    'title' => Language::trans('cancel')
]));

// ----------------------------
// "Mentés" gomb
// ----------------------------
echo (new Button([
    'id' => 'btn',
    'class' => 'btn btn-primary float-right',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'title' => Language::trans('save')
]))->submit();
?>
    </div>
<?php echo Form::end(); ?>
</div>