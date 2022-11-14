<?php

use app\core\form\Anchor;
use app\core\form\Button;
use app\core\form\Form;
use app\core\form\Select;
use app\core\Language;
use app\models\Human;

/**
 * human_new.php
 * User: kzoltan
 * Date: 2022-10-26
 * Time: 13:15
 */

/** @var Human $human */
/** @var array<Company> $companies */
/** @var array<Country> $countries */
/** @var string $title */

$this->title = $title;

?>


<h1><?php echo $this->title; ?></h1>

<div class="card">
    
    <div class="card-header"><?php echo $this->title; ?></div>
<?php
// --------------
// 'form' kezdete
// --------------
$form = Form::begin('', 'post'); 
?>
    <div class="card-body">
<?php 
// --------------
// Dolgozó neve
// --------------
?>        
        <?php echo $form->field($human, 'name'); ?>

        <div class="row">
            <div class="col border-right">
<?php
// --------
// Cégek
// --------
echo (new Select($human, [
                      'id' => 'company_id',   // Elem 'id' tulajdonsága
                    'name' => 'company_id',   // Elem 'name' tulajdonsága
                   'class' => 'form-control', // Elem osztálya
                   'title' => 'company_id',   // Elemhez tartozó felirat
             'value_field' => 'id',           // Elem 'value' értéke
          'selected_field' => 'id',           // Kijelölt 'object' egyik fele ('data')
    'model_selected_field' => 'id',           // Kijelölt 'object' másik fele ('model')
             'title_field' => 'name',         // 'object' elem felirata a 'data' halmazban
               'blank_row' => false,          // Kell üres 'object' a lisat elejére?
                    'data' => $companies,     // Megjelenítendő adatok
]));

?>
            </div>
            <div class="col">
<?php
// --------
// Országok
// --------
echo (new Select($human, [
                      'id' => 'country_id',   // Elem 'id' tulajdonsága
                    'name' => 'country_id',   // Elem 'name' tulajdonsága
                   'class' => 'form-control', // Elem osztálya
                   'title' => 'country_id',   // Elemhez tartozó felirat
             'value_field' => 'id',           // Elem 'value' értéke
          'selected_field' => 'id',           // Kijelölt 'object' egyik fele ('data')
    'model_selected_field' => 'country_id',   // Kijelölt 'object' másik fele ('model')
             'title_field' => 'country_hu',   // 'object' elem felirata a 'data' halmazban
               'blank_row' => false,          // Kell üres 'object' a lisat elejére?
                    'data' => $countries,     // Megjelenítendő adatok
]));
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
    'href' => '/humans',
    'title' => Language::trans('cancel')
]));
// ----------------------------
// "Mentés" gomb
// ----------------------------
echo (new Button([
    'id' => 'btn',
    'class' => 'btn btn-primary float-right',
    'style' => 'margin-right: 5px;margin-left: 5px;',
    'title' => Language::trans('save')
]))->submit();
?>
    </div>
<?php
// 'form' vége
Form::end();
?>
</div>