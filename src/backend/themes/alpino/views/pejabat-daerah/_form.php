<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PejabatDaerahExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pejabat-daerah-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'jabatan_daerah_id')->jabatanDaerahDropdownList() ?>

    <?php echo $form->field($model, 'penduduk_id')->pendudukDropdownList() ?>

    <?php echo $form->field($model, 'tanggal_mulai')->dateInput() ?>

    <?php echo $form->field($model, 'tanggal_selesai')->dateInput() ?>

    <?php echo $form->field($model, 'dasar_hukum')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->statusActiveDropdownList() ?>

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
