<?php
/**
 * @var $this app\core\View
 * @var $model app\models\ContactForm
 *
 */
$this->title = 'Kontakt';
?>

<h1>Kontakt</h1>

<?php $form = \app\core\form\Form::begin('', "post")?>
<?=$form->field($model, 'title') ?>
<?=$form->field($model, 'email') ?>
<?=$form->field($model, 'description') ?>
<button type="submit" class="btn btn-primary m2">Submit</button>
<?=\app\core\form\Form::end();?>

<!-- <form action="" method="post">
    <div class="form-group">
        <label class="form-label">Temat</label>
        <input type="text" name="title" class="form-control">
    </div>
    <div class="form-group">
        <label class="form-label">Email address</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Treść</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary m2">Submit</button>
</form> -->
