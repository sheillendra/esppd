<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OpdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="opd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'singkatan')->hiddenInput() ?>

    <?php echo $form->field($model, 'induk_id')->opdDropdownList(['prompt' => 'Tidak ada']) ?>
    
    <?php echo $form->field($model, 'text_kedudukan')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'baris_kop_1')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'baris_kop_2')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'status')->statusActiveDropdownList() ?>

    <?php echo $form->field($model, 'kode_urusan')->textInput() ?>

    <?php echo $form->field($model, 'kode_bidang')->textInput() ?>

    <?php echo $form->field($model, 'kode_unit')->textInput() ?>

    <?php echo $form->field($model, 'kode_sub')->textInput() ?>

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
