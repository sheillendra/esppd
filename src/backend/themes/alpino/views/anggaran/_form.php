<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use sheillendra\alpino\assets\BootstrapSelectAsset;

BootstrapSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\AnggaranExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anggaran-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->canEdit()): ?>
        <?php echo $form->field($model, 'opd_id')->opdDropdownList() ?>

        <?php echo $form->field($model, 'tahun_anggaran_id')->tahunAnggaranDropdownList() ?>

        <?php echo $form->field($model, 'jumlah')->textInput() ?>
    
    <?php endif; ?>

    <?php echo $form->field($model, 'kode_rekening')->textInput(['maxlength' => true]) ?>
    
    <?php echo $form->field($model, 'kegiatan')->textarea(['rows' => 2]) ?>

    <?php echo $form->field($model, 'status')->statusActiveDropdownList() ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'created_by')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_by')->textInput()  ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
