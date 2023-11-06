<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RincianBiayaSppdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rincian-biaya-sppd-ext-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php echo $form->field($model, 'pdfBuktiFile')->fileInput(['accept' => 'application/pdf']) ?>
    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
