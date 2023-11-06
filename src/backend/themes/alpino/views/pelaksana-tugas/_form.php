<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use sheillendra\alpino\assets\BootstrapSelectAsset;

BootstrapSelectAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\PelaksanaTugasExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pelaksana-tugas-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($model, 'surat_tugas_id')->hiddenInput([
        'class' => 'pegawai-ref'
    ])
    ?>

    <?php echo $form->field($model, 'pegawai_id')->pegawaiDropdownList() ?>

    <?php echo $form->field($model, 'penduduk_id')->pendudukDropdownList() ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
