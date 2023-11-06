<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\KategoriBiayaSppdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kategori-biaya-sppd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->statusActiveDropdownList() ?>

    <?php // echo $form->field($model, 'urutan')->textInput() ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <?php echo $form->field($model, 'detail_column[0]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[1]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[2]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[3]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[4]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[5]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[6]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[7]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[8]')->textInput() ?>
    <?php echo $form->field($model, 'detail_column[9]')->textInput() ?>
    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'created_by')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
