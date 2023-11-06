<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use common\models\WilayahExt;
use common\models\AnggaranExt;
use sheillendra\alpino\assets\BootstrapSelectAsset;

BootstrapSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sppd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'anggaran_id')->anggaranDropdownList()?>

    <?php // echo $form->field($model, 'pelaksana_tugas_id')->textInput() ?>

    <?php echo $form->field($model, 'nomor')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'tanggal')->dateInput() ?>

    <?php
    echo $form->field($model, 'wilayah_berangkat')->dropDownList(WilayahExt::dataList(), [
        'prompt' => 'Pilih tempat berangkat',
        'data' => ['live-search' => 'true'],
    ])
    ?>
    
    <?php
    echo $form->field($model, 'wilayah_tujuan')->dropDownList(WilayahExt::dataList(), [
        'prompt' => 'Pilih tempat tujuan',
        'data' => ['live-search' => 'true'],
    ])
    ?>

    <?php echo $form->field($model, 'tanggal_berangkat')->dateInput() ?>

    <?php echo $form->field($model, 'tanggal_kembali')->dateInput() ?>

    <?php echo $form->field($model, 'alat_angkutan')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>