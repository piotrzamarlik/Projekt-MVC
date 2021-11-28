<?php
/**
 * @var $model app\models\User
 */
?>
<h1>Rejestracja</h1>
<?php $form = \app\core\form\Form::begin('', "post") ?>
    <div class="row">
        <div class="col">
            <?=$form->field($model, 'firstname') ?>
        </div>
        <div class="col">
            <?=$form->field($model, 'lastname') ?>
        </div>
    <?=$form->field($model, 'email') ?>
    <?=$form->field($model, 'password')->passwordField() ?>
    <?=$form->field($model, 'confirmPassword')->passwordField() ?>
    <button type="submit" class="btn btn-primary m-2">Zarejestruj</button>
<?=\app\core\form\Form::end() ?>