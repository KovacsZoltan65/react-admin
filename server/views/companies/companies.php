<?php
/**
 * companies.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 13:00
 */

/** @var object $companies */
/** @var Company $company */

use app\core\form\Anchor;
use app\core\Language;
use app\models\Company;

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

// =================
// "NEW" button
// =================
echo(new Anchor([
    'id' => "btn_$create_id",
    'class' => 'btn btn-primary float-right',
    'type' => 'button',
    'href' => "company_new",
    'icon' => 'bi bi-plus-circle'
]))->button();
?>
        
    </div>
    
    <div class="card-body">
        
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="align-middle text-center col-md-1">#</th>
                <th><?php echo Language::trans('name'); ?></th>
                <th class="text-center"><?php echo Language::trans('status'); ?></th>
                <th class="col-md-2"><?php echo Language::trans('functions'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach ($companies as $company):
                ?>
                <tr>
                    <td class="align-middle text-center"><?php echo $company->id; ?></td>
                    <td class="align-middle"><?php echo $company->name; ?></td>
                    <td class="align-middle">
                        <?php $company->getStatusName(); ?>
                    </td>
                    <td>
                        <?php
                        if ($company->status === 0):
                            // =================
                            // "EDIT" button
                            // =================
                            echo(new Anchor([
                                'id' => "btn_$edit_id",
                                'class' => 'btn btn-primary',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'type' => 'button',
                                'href' => "company_edit/$company->id",
                                'icon' => 'bi bi-pencil'
                            ]))->button();
                            // =================
                            // "RESTORE" button
                            // =================
                            echo(new Anchor([
                                'id' => "btn_$restore_id",
                                'class' => 'btn btn-info',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'type' => 'button',
                                'href' => "company_restore/$company->id",
                                'icon' => 'bi bi-arrow-clockwise'
                            ]))->button();

                        elseif ($company->status === 1):
                            // =================
                            // "EDIT" button
                            // =================
                            echo(new Anchor([
                                'id' => "btn_$edit_id",
                                'class' => 'btn btn-primary',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'type' => 'button',
                                'href' => "company_edit/$company->id",
                                'icon' => 'bi bi-pencil'
                            ]))->button();
                            // =================
                            // "DELETE" button
                            // =================
                            echo(new Anchor([
                                'id' => "btn_$restore_id",
                                'class' => 'btn btn-danger',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'type' => 'button',
                                'href' => "company_delete/$company->id",
                                'icon' => 'bi bi-trash'
                            ]))->button();
                        elseif ($company->status === 2):
                            // =================
                            // "RESTORE" button
                            // =================
                            echo(new Anchor([
                                'id' => "btn_$restore_id",
                                'class' => 'btn btn-info',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'type' => 'button',
                                'href' => "company_restore/$company->id",
                                'icon' => 'bi bi-arrow-clockwise'
                            ]))->button();
                        endif;
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
    
    <div class="card-footer"></div>
    
</div>