<?php

use app\core\form\Form;
use app\core\Language;

/**
 * company_deletes.php
 * User: kzoltan
 * Date: 2022-07-06
 * Time: 16:15
 */

$this->title = Language::trans('delete');

?>
<style>
    card-link:hover{text-decoration:none}.card-link+.card-link{margin-left:1.25rem}
</style>
<h1>Company_delete</h1>

<?php $form = Form::begin('', 'post'); ?>
<input id="id" name="id" type="hidden" value="<?php echo $model->id; ?>" />

<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title"><?php echo $model->name; ?></h5>
        <h6 class="card-subtitle mb-2 text-muted"><?php echo $model->name; ?></h6>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    
        <button id="btn_submit" name="btn_submit" 
                type="submit" class="btn btn-link"><?php echo Language::trans('delete'); ?></button>
    </div>
</div>
<?php echo Form::end(); ?>