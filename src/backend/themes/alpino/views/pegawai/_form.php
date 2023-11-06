<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use sheillendra\alpino\assets\BootstrapSelectAsset;

BootstrapSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\PegawaiExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pegawai-ext-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php // echo $form->field($model, 'opd_id')->textInput() ?>
    <?php echo $form->field($model, 'opd_id')->opdDropdownList() ?>

    <?php echo $form->field($model, 'gelar_depan')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'nama_tanpa_gelar')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'gelar_belakang')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'nip')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'pangkat_golongan_id')->pangkatGolonganDropdownList() ?>

    <?php echo $form->field($model, 'eselon_id')->eselonDropdownList() ?>

    <?php echo $form->field($model, 'status')->statusActiveDropdownList() ?>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'created_by')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
