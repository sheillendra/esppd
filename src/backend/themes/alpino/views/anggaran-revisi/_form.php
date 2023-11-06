<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AnggaranRevisiExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anggaran-revisi-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'anggaran_id')->hiddenInput() ?>

    <?php echo $form->field($model, 'uraian')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'saldo_awal')->textInput() ?>

    <?php echo $form->field($model, 'revisi')->textInput() ?>

    <?php // echo $form->field($model, 'saldo_akhir')->textInput() ?>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'created_by')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
