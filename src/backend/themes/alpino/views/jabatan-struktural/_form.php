<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JabatanStrukturalExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jabatan-struktural-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'opd_id')->opdDropdownList() ?>

    <?php echo $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'nama_2')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'singkatan')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'tingkat_sppd')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->statusActiveDropdownList() ?>

    <?php // echo $form->field($model, 'urutan')->textInput() ?>

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
