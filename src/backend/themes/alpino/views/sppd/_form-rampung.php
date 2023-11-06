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


    <?php echo $form->field($model, 'tanggal_rampung')->dateInput([
        'minDate' => $model->tanggal_kembali,
    ]) ?>

    <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>