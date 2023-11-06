<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use common\models\SatuanExt;
use sheillendra\alpino\assets\BootstrapSelectAsset;

BootstrapSelectAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\RincianBiayaSppdExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rincian-biaya-sppd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'sppd_id')->hiddenInput() ?>

    <?php // echo $form->field($model, 'jenis_biaya_id')->textInput() ?>

    <?php echo $form->field($model, 'kategori_biaya_id')->hiddenInput() ?>
    <div class="form-group">
        <label class="control-label">Kategori</label>
        <div class="form-control"><?php echo $model->kategoriBiaya->nama ?></div>
    </div>

    <?php
    echo $form->field($model, 'tanggal')->dateInput([
        'minDate' => $model->sppd->tanggal_berangkat,
        'maxDate' => $model->sppd->tanggal_kembali,
    ])
    ?>

    <?php echo $form->field($model, 'uraian')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'volume')->textInput(['type' => 'number']) ?>

    <?php // echo $form->field($model, 'satuan_id')->dropDownList($items) ?>
    <?php
    echo $form->field($model, 'satuan_id')->dropDownList(SatuanExt::dataList(), [
        'prompt' => 'Pilih satuan',
            //'data' => ['live-search' => 'true'],
    ])
    ?>

    <?php echo $form->field($model, 'harga')->textInput() ?>

    <?php // echo $form->field($model, 'total')->textInput() ?>

    <?php // echo $form->field($model, 'urutan')->textInput() ?>

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
<?php
$today = date('Y-m-d');
$this->registerJs(<<<JS
    $('#tanggal').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        clearButton: true,
        weekStart: 1,
        time: false,
        minDate: '{$model->sppd->tanggal_berangkat}',
        maxDate: '{$model->sppd->tanggal_kembali}',
    });

JS
);
