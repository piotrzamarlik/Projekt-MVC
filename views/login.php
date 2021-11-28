<?php
    /**
     * @var $model app\models\User
     */
?>
<h1>Logowanie</h1>
<?php $form = \app\core\form\Form::begin('', "post")?>
    <div class="row">
        <div class="col-4">
            <?php echo $form->field($model, 'email') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <?php echo $form->field($model, 'password')->passwordField() ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary m-2">Zaloguj</button>
<?php echo \app\core\form\Form::end() ?>
