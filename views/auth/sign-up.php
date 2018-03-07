<?php

/* @var $this yii\web\View */
/* @var $model app\models\SignUpForm */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Sign up';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
<div class="sign-up">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($registration_success): ?>
        <div class="alert alert-success"> Регистрация успешно выполнена! </div>
        <p>
            Перейдите на страницу авторизации
            <?= Html::a("Sign in", ['auth/login'], ['class' => 'btn btn-primary']); ?>
        </p>
    <?php else: ?>

        <?php $form = ActiveForm::begin([
            'validationUrl' => 'validate-form',
            'options' => ['data-pjax' => true]
        ]); ?>

        <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Create Account', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>

</div>
<?php Pjax::end(); ?>
<!-- sign-up -->
