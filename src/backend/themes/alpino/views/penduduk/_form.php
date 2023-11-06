<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PendudukExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penduduk-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'nik')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'gelar_depan')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'nama_tanpa_gelar')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'gelar_belakang')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'jenis_kelamin')->dropDownList([1 => 'Laki-laki', 2 => 'Perempuan']) ?>

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
