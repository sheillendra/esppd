<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProdukHukumExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="produk-hukum-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'tentang')->textarea(['rows' => 2]) ?>

    <?php echo $form->field($model, 'pdf_url')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'pdf_lampiran_url')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'created_by')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
