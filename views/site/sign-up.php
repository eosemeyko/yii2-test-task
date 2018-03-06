<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\SignUpForm */
/* @var $form ActiveForm */
?>
<div class="sign-up">

    <?php $form = ActiveForm::begin([
        'action' => 'create-account',
        'validationUrl' => 'validate-form'
    ]); ?>

        <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Create Account', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- sign-up -->
