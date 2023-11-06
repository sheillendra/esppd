<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JenisBiayaSppdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jenis-biaya-sppd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'kategori_biaya_sppd_id')->textInput() ?>

    <?php echo $form->field($model, 'satuan_id')->textInput() ?>

    <?php echo $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'pembuktian')->textInput() ?>

    <?php echo $form->field($model, 'pergi_pulang')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

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
