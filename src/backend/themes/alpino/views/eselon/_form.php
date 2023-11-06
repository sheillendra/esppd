<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EselonExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eselon-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'eselon')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'pangkat_min')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'pangkat_max')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'tingkat_sppd')->textInput(['maxlength' => true]) ?>

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
