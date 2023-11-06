<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use common\models\WilayahExt;
use common\models\AnggaranExt;
use sheillendra\alpino\assets\BootstrapSelectAsset;

BootstrapSelectAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sppd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'pdfTtdFile')->fileInput() ?>

    <?php echo $form->field($model, 'pdf_url_ttd')->textInput()
            ->hint('Diisi jika pdf diupload di tempat lain') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>