<?php
    /**
     * @var $model app\models\User
     */
?>
<h1>Rejestracja</h1>
<?php $form = \app\core\form\Form::begin('', "post")?>
    <div class="row">
        <div class="col">
            <?php echo $form->field($model, 'firstname') ?>
        </div>
        <div class="col">
            <?php echo $form->field($model, 'lastname') ?>
        </div>
    <?php echo $form->field($model, 'email') ?>
    <?php echo $form->field($model, 'password')->passwordField() ?>
    <?php echo $form->field($model, 'confirmPassword')->passwordField() ?>
    <button type="submit" class="btn btn-primary m-2">Zarejestruj</button>
<?php echo \app\core\form\Form::end() ?>