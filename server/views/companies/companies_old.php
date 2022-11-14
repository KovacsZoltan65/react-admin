<?php

use app\controllers\CountryController;
use app\controllers\CurrencyController;
use app\core\form\Button;
use app\core\form\Modal;
use app\core\Language;

//use app\core\form\Anchor;
//use app\core\form\Button;

/**
 * companies.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 13:00
 */

//$this->title = 'Companies';
$this->title = Language::trans('companies');

$create_modal_id = 'modal_create';
$edit_modal_id = 'modal_edit';
$delete_modal_id = 'modal_delete';
$restore_modal_id = 'modal_restore';

$countries = (new CountryController)->getCountriesToSelect();
$currencies = (new CurrencyController)->getCurrenciesToSelect();

$modal_body = '<input type="hidden" id="edit_id" name="edit_id" value=""/>
    <div class="form-group">
        <label for="name">' . Language::trans('name') . '</label>
        <input type="text" class="form-control" id="name"/>
        <div id="nameHelp" class="valid-feedback"></div>
    </div>

    <div class="row">
        <div class="col">

            <div class="form-group">
                <label for="currency">' . Language::trans('currency') . '</label>
                <select class="form-control" id="currency">
                    <option value="0">' . Language::trans('choose') . '</option>';
foreach( $currencies as $currency )
{
    $modal_body .= '<option value="' . $currency->currency . '">' . $currency->currency . '</option>';
}
$modal_body .= '</select>
                <div id="currencyHelp" class="valid-feedback"></div>
            </div>
        </div>

        <div class="col">

            <div class="form-group">
                <label for="country_id">' . Language::trans('country') . '</label>
                <select class="form-control" id="country_id">
                    <option value="0">' . Language::trans('choose') . '</option>';

foreach($countries as $country)
{
    $modal_body .= '<option value="' . $country->id . '" >' . $country->country_hu . '</option>';
}

$modal_body .= '
                </select>
                <div id="country_idHelp" class="valid-feedback"></div>
            </div>
        </div>
    </div>';

$delete_modal_body = '<input id="delete_id" name="delete_id" type="hidden" value="" />
        Biztos, hogy törölni akarja a rekordot?';

?>

<h1><?php echo $this->title; ?></h1>

<div>
<?php
// ----------.
// NEW MODAL
// ----------
echo (new Button([
    'id' => 'btn_' . $create_modal_id,
    'class' => 'btn btn-primary',
    //'title' => 'delete modal',
    'icon' => 'bi bi-plus-circle',
    'style' => 'margin-right: 5px;margin-left: 5px',
    'data-toggle' => 'modal',
    'data-target' => "#$edit_modal_id",
    'data-id' => 0,
    'data-whatever' => Language::trans('add new'),
]))->modal();

?>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo Language::trans('name'); ?></th>
            <th><?php echo Language::trans('status'); ?></th>
            <th><?php echo Language::trans('functions'); ?></th>
        </tr>
    </thead>
    <tbody>
<?php
/** @var object $companies */
foreach($companies as $company):
?>
        <tr>
            <td><?php echo $company->id; ?></td>
            <td><?php echo $company->name; ?></td>
            <td>
<?php
if( $company->status == 0 ):
    echo Language::trans('inactive');
elseif ( $company->status == 1 ):
    echo Language::trans('active');
elseif ( $company->status == 2 ):
    echo Language::trans('deleted');
endif;
?>
            </td>
            <td>

<?php

//echo (new Anchor(['id' => 'btn_edit','class' => 'btn btn-primary','href' => 'company_edit/' . $company->id,'icon' => 'bi bi-pencil',]));

if( $company->status == 0 ):
    // edit button
    echo (new Button([
        'id' => 'btn_' . $edit_modal_id,
        'class' => 'btn btn-primary',
        //'title' => 'delete modal',
        'icon' => 'bi bi-pencil',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-toggle' => 'modal',
        'data-target' => "#$edit_modal_id",
        'data-id' => $company->id,
        'data-whatever' => Language::trans('edit'),
    ]))->modal();

    // restore button
    echo (new Button([
        'id' => 'btn_' . $restore_modal_id,
        'class' => 'btn btn-info',
        'icon' => 'bi bi-arrow-clockwise',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-toggle' => 'modal',
        'data-target' => "#$restore_modal_id",
        'data-id' => $company->id,
        'data-whatever' => 'restore',
    ]))->modal();

elseif ( $company->status == 1 ):
    // edit button
    echo (new Button([
        'id' => 'btn_' . $edit_modal_id,
        'class' => 'btn btn-primary',
        //'title' => 'delete modal',
        'icon' => 'bi bi-pencil',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-toggle' => 'modal',
        'data-target' => "#$edit_modal_id",
        'data-id' => $company->id,
        'data-whatever' => Language::trans('edit'),
    ]))->modal();
    // delete button
    echo (new Button([
        'id' => 'btn_' . $delete_modal_id,
        'class' => 'btn btn-danger',
        //'title' => 'delete modal',
        'icon' => 'bi bi-trash',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-toggle' => 'modal',
        'data-target' => "#$delete_modal_id",
        'data-id' => $company->id,
        'data-whatever' => Language::trans('delete'),
    ]))->modal();
elseif ( $company->status == 2 ):
    // restore button
    echo (new Button([
        'id' => 'btn_' . $restore_modal_id,
        'class' => 'btn btn-info',
        'icon' => 'bi bi-arrow-clockwise',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-toggle' => 'modal',
        'data-target' => "#$restore_modal_id",
        'data-id' => $company->id,
        'data-whatever' => 'restore',
    ]))->modal();
endif;

// -----------------
// EDIT MODAL BUTTON
// -----------------


#echo (new Anchor(['id' => 'btn_delete','class' => 'btn btn-danger','href' => 'company_delete/' . $company->id,'icon' => 'bi bi-trash',]));
// -------------------
// DELETE MODAL BUTTON
// -------------------

?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php

// -----------------------------
// EDIT MODAL
// -----------------------------
echo (new Modal([
    'id' => $edit_modal_id,
    'modal_title' => 'edit modal',
    'modal_body' => $modal_body,
    'form_action' => 'post',
    'form_method' => '/company_edit/' . $edit_modal_id,
    'modal_cancel_button' => [
        'id' => 'cancel_button',
        'class' => 'btn btn-secondary',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-dismiss' => 'modal',
        'title' => Language::trans('cancel'),
    ],
    'modal_function_button' => [
        'id' => 'save_button',
        'class' => 'btn btn-primary',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'title' => Language::trans('save'),
    ],
]))->edit();

// -----------------------------
// DELETE MODAL
// -----------------------------
echo (new Modal([
    'id' => $delete_modal_id,
    'modal_title' => 'delete modal',
    'modal_body' => $delete_modal_body,
    'form_action' => '/api/company/delete',
    'form_method' => 'post',
    'modal_cancel_button' => [
        'id' => 'cancel_button',
        'class' => 'btn btn-secondary',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'data-dismiss' => 'modal',
        'title' => Language::trans('cancel'),
    ],
    'modal_function_button' => [
        'id' => 'delete_button',
        'class' => 'btn btn-danger',
        'style' => 'margin-right: 5px;margin-left: 5px',
        'title' => Language::trans('delete'),
        'data-id' => $company->id,
    ],
]))->delete();

?>

<script>
$(document).ready(function(e)
{
    // "SAVE" BUTTON megnyomása
    //$('#save_button').on('click', function(event)
    //{
    //    console.log('save click');
    //});

    // "DELETE" BUTTON megnyomása
    //$('#delete_button').on('click', function(event)
    //{
        //console.log('delete click');
        /*
        var button = $(event.relatedTarget);
        var id = $('#delete_id').val();
        //console.log(id);

        $.ajax({
            url: 'api/company/delete/' + id,
            type: 'get',
            async: 'false',
            success: function(data){ console.log(data) },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log('error');
            }
        });
        */
        /*
        $.ajax({
            url: 'api/company/delete',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            async: false,
            success: function(data)
            {
                console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log('error');
            }
        });
        */
    //});

    // "EDIT" MODAL megnyitása
    $('#<?php echo $edit_modal_id; ?>').on('show.bs.modal', function (event){
        // A gomb, ami kiváltotta a triggert
        var button = $(event.relatedTarget);
        var whatever = button.data('whatever');
        var id = button.data('id');

        var modal = $(this);
        modal.find('.modal-title').text(whatever);
        //modal.find('.modal-body input').val(recipient);

        // Rekord azonosító beírása az űrlap edit_id mezőjéba
        modal.find('.modal-body #edit_id').val(id);
        if( id != 0 )
        {
            $.ajax({
                type: 'get',
                url: '/api/company/' + id,
                async: true,
                success: function(str_data)
                {
                    json_data = JSON.parse(str_data);

                    // név
                    $('input[id=name]').val(json_data.name);

                    // Pénznem
                    $('select[id=currency] option[value="'+ json_data.currency +'"]').attr('selected','selected');

                    // Ország
                    $('select[id=country_id] option[value="'+ json_data.country_id +'"]').attr('selected','selected');

                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('error');
                }
            });
        }
    });

    // "EDIT" MODAL bezárása
    $('#<?php echo $edit_modal_id; ?>').on('hide.bs.modal', function(event){
        // A gomb, ami kiváltotta a triggert
        //var button = $(event.relatedTarget);
        //var modal = $(this);

        $(':input','#<?php echo $edit_modal_id; ?>')
                .not(':button, :submit, :reset, :hidden')
                .val('')
                .prop('checked', false)
                .prop('selected', false);

    });

    // "DELETE" MODAL ablak megnyitása
    $('#<?php echo $delete_modal_id; ?>').on('show.bs.modal', function (event){
        // A gomb, ami kiváltotta a triggert
        var button = $(event.relatedTarget);
        var whatever = button.data('whatever');
        var id = button.data('id');

        var modal = $(this);
        modal.find('.modal-title').text(whatever);

        modal.find('.modal-body #delete_id').val(id);
    });

    // "DELETE" MODAL bezárása
    $('#<?php echo $delete_modal_id; ?>').on('hide.bs.modal', function(event)
    {
        $(':input','#<?php echo $delete_modal_id; ?>')
                .not(':button, :submit, :reset, :hidden')
                .val('')
                .prop('checked', false)
                .prop('selected', false);
    });



    //$('#btn_modal_create').on('click', function(event){
    //    console.log('new');
    //});

});
</script>