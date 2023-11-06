<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BesaranBiayaSppdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="besaran-biaya-sppd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'pangkat_golongan_id')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'eselon_id')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'jabatan_daerah_id')->textInput() ?>

    <?php echo $form->field($model, 'jabatan_struktural_id')->textInput() ?>

    <?php echo $form->field($model, 'jabatan_fungsional_id')->textInput() ?>

    <?php echo $form->field($model, 'kategori_wilayah')->textInput() ?>

    <?php echo $form->field($model, 'wilayah_id')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'jenis_biaya_sppd_id')->textInput() ?>

    <?php echo $form->field($model, 'jumlah')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'produk_hukum_id')->textInput() ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'created_by')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
