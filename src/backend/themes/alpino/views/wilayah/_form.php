<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WilayahExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wilayah-ext-form">

    <?php $form = ActiveForm::begin([
        'fieldClass' => 'common\widgets\ActiveField'
    ]); ?>

    <?php echo $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'kode_induk')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'kode_kemendagri')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'ibukota')->booleanDropdownList() ?>

    <?php echo $form->field($model, 'level')->levelWilayahDropdownList() ?>

    <?php echo $form->field($model, 'kategori')->kategoriWilayahDropdownList() ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

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
