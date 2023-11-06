<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OpdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="opd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'urusan_code')->textInput() ?>

    <?= $form->field($model, 'bidang_code')->textInput() ?>

    <?= $form->field($model, 'unit_code')->textInput() ?>

    <?= $form->field($model, 'sub_code')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shortname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'line_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'line_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
