<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AnggaranRevisiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anggaran-revisi-ext-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'anggaran_id') ?>

    <?php echo $form->field($model, 'tanggal') ?>

    <?php echo $form->field($model, 'uraian') ?>

    <?php echo $form->field($model, 'saldo_awal') ?>

    <?php // echo $form->field($model, 'revisi') ?>

    <?php // echo $form->field($model, 'saldo_akhir') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
