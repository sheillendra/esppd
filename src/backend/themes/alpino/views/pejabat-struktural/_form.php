<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use sheillendra\alpino\assets\BootstrapSelectAsset;
use sheillendra\alpino\assets\DatetimePickerAsset;

BootstrapSelectAsset::register($this);
DatetimePickerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\PejabatStrukturalExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pejabat-struktural-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->canEdit()): ?>
        <?php echo $form->field($model, 'jabatan_struktural_id')->jabatanStrukturalDropdownList() ?>
        <?php echo $form->field($model, 'pegawai_id')->pegawaiDropdownList() ?>
    <?php endif; ?>

    <?php echo $form->field($model, 'tanggal_mulai')->dateInput() ?>

    <?php echo $form->field($model, 'tanggal_selesai')->dateInput() ?>

    <?php echo $form->field($model, 'dasar_hukum')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->dropDownList([1 => 'Aktif', 0 => 'Tidak aktif']) ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
