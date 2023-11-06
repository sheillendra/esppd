<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

//use sheillendra\alpino\assets\BootstrapSelectAsset;
//use sheillendra\alpino\assets\DatetimePickerAsset;
//BootstrapSelectAsset::register($this);
//DatetimePickerAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\SuratTugasExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="surat-tugas-ext-form">

    <?php $form = ActiveForm::begin(['id' => 'surat-tugas-form']); ?>

    <?php echo $form->field($model, 'tanggal_terbit')->dateInput() ?>

    <?php echo $form->field($model, 'tanggal_mulai')->dateInput() ?>

    <?php echo $form->field($model, 'jumlah_hari')->textInput(['type' => 'number']) ?>

    <?php echo $form->field($model, 'nomor')->textInput(['maxlength' => true]) ?>

    <?php
    echo $form->field($model, 'perintahDari')->dropDownList($model::dataListPejabatPemerintah(), [
        'data' => ['live-search' => 'true'],
    ])
    ?>

    <?php echo $form->field($model, 'maksud')->textarea(['rows' => 2]) ?>

        <?php echo $form->field($model, 'keterangan')->textarea(['rows' => 2]) ?>

    <div class="form-group">
    <?php echo Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
