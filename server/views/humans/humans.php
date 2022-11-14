<?php

use app\core\Language;

/**
 * humans.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 13:45
 */

/** @var object<\app\models\Human> $humans */
/** @var \app\models\Human $human */

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
echo(new \app\core\form\Anchor([
    'id' => "btn_$create_id",
    'class' => 'btn btn-primary float-right',
    'type' => 'button',
    'href' => "human_new",
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
                <?php foreach($humans as $human): ?>
                <tr>
                    <td class="align-middle text-center"><?php echo $human->id; ?></td>
                    <td class="align-middle"><?php echo $human->name; ?></td>
                    <td class="align-middle">
                        <?php

                        $human->getStatusName();

                        if ($human->status === 0):
                            echo Language::trans('inactive');
                        elseif ($human->status === 1):
                            echo Language::trans('active');
                        elseif ($human->status === 2):
                            echo Language::trans('deleted');
                        endif;
                        ?>
                    </td>
                    <td>
                        <?php
                        if( $human->status === 0 ):
                            // =================
                            // "EDIT" button
                            // =================
                            echo (new \app\core\form\Anchor([
                                'id' => "btn_$edit_id",
                                'class' => 'btn btn-primary',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'href' => "human_edit/$human->id",
                                'icon' => 'bi bi-pencil',
                            ]))->button();
                            // =================
                            // "DELETE" button
                            // =================
                            echo (new \app\core\form\Anchor([
                                'id' => "btn_$delete_id",
                                'class' => 'btn btn-danger',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'href' => "human_delete/$human->id",
                                'icon' => 'bi bi-trash',
                            ]))->button();
                        elseif( $human->status === 1 ):
                            // =================
                            // "EDIT" button
                            // =================
                            echo (new \app\core\form\Anchor([
                                'id' => "btn_$edit_id",
                                'class' => 'btn btn-primary',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'href' => "human_edit/$human->id",
                                'icon' => 'bi bi-pencil',
                            ]))->button();
                            // =================
                            // "DELETE" button
                            // =================
                            echo (new \app\core\form\Anchor([
                                'id' => "btn_$delete_id",
                                'class' => 'btn btn-danger',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'href' => "human_delete/$human->id",
                                'icon' => 'bi bi-trash',
                            ]))->button();
                        elseif( $human->status === 2 ):
                            // =================
                            // "RESTORE" button
                            // =================
                            echo (new \app\core\form\Anchor([
                                'id' => "btn_$restore_id",
                                'class' => 'btn btn-info',
                                'style' => 'margin-right: 5px;margin-left: 5px',
                                'href' => "human_restore/$human->id",
                                'icon' => 'bi bi-arrow-clockwise',
                            ]))->button();
                        endif;
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!--<div class="card-footer"></div>-->
    
</div>

