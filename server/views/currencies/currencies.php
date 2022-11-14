<?php

/**
 * currencies.php
 * User: kzoltan
 * Date: 2022-10-05
 * Time: 09:30
 */

use app\core\Language;

$this->title = $title;

$create_id = 'create';
$edit_id = 'edit';
$delete_id = 'delete';
$restore_id = 'restore';

?>

<h1><?php echo $this->title; ?></h1>

<div class="card">
    
    <div class="card-header">
<?php
echo $this->title;

// ----------------
// "NEW" button
// ----------------
echo(new Anchor([
    'id' => "btn_$create_id",
    'class' => 'btn btn-primary float-right',
    'type' => 'button',
    'href' => "currency_new",
    'icon' => 'bi bi-plus-circle'
]))->button();
?>
    </div>
    
    <div class="card-body">
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo Language::trans('name'); ?></th>
                    <th><?php echo Language::trans('functions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($currencies as $currency): ?>
                <tr>
                    <td><?php echo $currency->currency; ?></td>
                    <td><?php echo $currency->currency_symbol; ?></td>
                    <td></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
    
    <!--<div class="card-footer"></div>-->
    
</div>