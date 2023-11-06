<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SppdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sppd-ext-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'anggaran_id') ?>

    <?php echo $form->field($model, 'pelaksana_tugas_id') ?>

    <?php echo $form->field($model, 'nomor') ?>

    <?php echo $form->field($model, 'tanggal') ?>

    <?php // echo $form->field($model, 'wilayah_berangkat') ?>

    <?php // echo $form->field($model, 'wilayah_tujuan') ?>

    <?php // echo $form->field($model, 'tanggal_berangkat') ?>

    <?php // echo $form->field($model, 'tanggal_kembali') ?>

    <?php // echo $form->field($model, 'alat_angkutan') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'pdf_url_blank') ?>

    <?php // echo $form->field($model, 'pdf_url_barcode') ?>

    <?php // echo $form->field($model, 'pdf_url_ttd') ?>

    <?php // echo $form->field($model, 'pdf2_url_blank') ?>

    <?php // echo $form->field($model, 'pdf2_url_barcode') ?>

    <?php // echo $form->field($model, 'pdf2_url_ttd') ?>

    <?php // echo $form->field($model, 'pdf3_url_blank') ?>

    <?php // echo $form->field($model, 'pdf3_url_barcode') ?>

    <?php // echo $form->field($model, 'pdf3_url_ttd') ?>

    <?php // echo $form->field($model, 'pdf4_url_blank') ?>

    <?php // echo $form->field($model, 'pdf4_url_barcode') ?>

    <?php // echo $form->field($model, 'pdf4_url_ttd') ?>

    <?php // echo $form->field($model, 'pdf5_url_blank') ?>

    <?php // echo $form->field($model, 'pdf5_url_barcode') ?>

    <?php // echo $form->field($model, 'pdf5_url_ttd') ?>

    <?php // echo $form->field($model, 'pdf6_url_blank') ?>

    <?php // echo $form->field($model, 'pdf6_url_barcode') ?>

    <?php // echo $form->field($model, 'pdf6_url_ttd') ?>

    <?php // echo $form->field($model, 'pdf7_url_blank') ?>

    <?php // echo $form->field($model, 'pdf7_url_barcode') ?>

    <?php // echo $form->field($model, 'pdf7_url_ttd') ?>

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
