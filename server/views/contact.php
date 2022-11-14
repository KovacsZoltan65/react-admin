<?php

/**
 * contact.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 07:18
 */

use app\core\form\Form;
use app\core\form\TextAreaField;

/** @var $this \app\core\View */
/** @var $model \app\models\ContactForm */

$this->title = 'Contact';
?>

<h1>Contact</h1>

<?php $form = Form::begin('', 'post'); ?>
<?php echo $form->field($model, 'subject'); ?>
<?php echo $form->field($model, 'email'); ?>
<?php echo new TextAreaField($model, 'body'); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end(); ?>