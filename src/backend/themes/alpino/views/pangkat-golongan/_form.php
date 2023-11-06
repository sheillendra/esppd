<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PangkatGolonganExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pangkat-golongan-ext-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if ($model->canEdit()): ?>
        <?php echo $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'pangkat')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'golongan')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'ruang')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'tingkat_sppd')->dropDownList(\common\models\SppdExt::TINGKAT_SPPD) ?>
    <?php endif; ?>
    <?php echo $form->field($model, 'status')->dropDownList([1 => 'Aktif', 0 => 'Tidak aktif']) ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'created_by')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
