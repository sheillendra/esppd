<?php
/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use asn\themes\alpino\assets\AppLoginAsset;

AppLoginAsset::register($this);

$this->context->layout = '//login';
$this->title = 'Admin Login';

$this->params['title'] = $this->title;
$this->params['description'] = 'Sub Portal ini dikhususkan untuk ASN BPKAD Kab. Halmahera Timur yang mempunyai akses sebagai ADMIN';
?>


<div class="card-plain">
    <div class="header">
        <h5>Log in</h5>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'form']); ?>
    <?php echo $form->field($model, 'nip')->textInput(['autofocus' => true, 'placeholder' => 'NIP', 'autocomplete' => 'new-password'])->label(false) ?>
    <?php echo $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'autocomplete' => 'new-password'])->label(false) ?>
    <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
    <div class="footer">
        <?php echo Html::submitButton('LOGIN', ['class' => 'btn btn-primary btn-round btn-block', 'name' => 'login-button']) ?>
        <?php // echo Html::a('SIGN UP', ['/signup'], ['class' => 'btn btn-primary btn-simple btn-round btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <!--<a href="forgot-password.html" class="link">Forgot Password?</a>-->
</div>