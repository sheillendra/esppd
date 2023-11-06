<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BesaranBiayaSppdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="besaran-biaya-sppd-ext-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'pangkat_golongan_id') ?>

    <?php echo $form->field($model, 'eselon_id') ?>

    <?php echo $form->field($model, 'jabatan_daerah_id') ?>

    <?php echo $form->field($model, 'jabatan_struktural_id') ?>

    <?php // echo $form->field($model, 'jabatan_fungsional_id') ?>

    <?php // echo $form->field($model, 'kategori_wilayah') ?>

    <?php // echo $form->field($model, 'wilayah_id') ?>

    <?php // echo $form->field($model, 'jenis_biaya_sppd_id') ?>

    <?php // echo $form->field($model, 'jumlah') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'produk_hukum_id') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
