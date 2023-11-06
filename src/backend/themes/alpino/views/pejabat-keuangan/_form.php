<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use sheillendra\alpino\assets\BootstrapSelectAsset;
use sheillendra\alpino\assets\DatetimePickerAsset;

BootstrapSelectAsset::register($this);
DatetimePickerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\PejabatKeuanganExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pejabat-keuangan-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'opd_id')->opdDropdownList() ?>

    <?php echo $form->field($model, 'jabatan_keuangan_id')->jabatanKeuanganDropdownList() ?>

    <?php echo $form->field($model, 'pegawai_id')->pegawaiDropdownList() ?>

    <?php echo $form->field($model, 'tanggal_mulai')->dateInput() ?>

    <?php echo $form->field($model, 'tanggal_selesai')->dateInput() ?>

    <?php echo $form->field($model, 'dasar_hukum')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->statusActiveDropdownList() ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
