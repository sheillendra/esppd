<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EselonExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eselon-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'eselon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pangkat_min')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pangkat_max')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tingkat_sppd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uh_sppd_ld')->textInput() ?>

    <?= $form->field($model, 'uh_sppd_dd')->textInput() ?>

    <?= $form->field($model, 'urep_sppd_ld')->textInput() ?>

    <?= $form->field($model, 'urep_sppd_dd')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
