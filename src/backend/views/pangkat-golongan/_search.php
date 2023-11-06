<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PangkatGolonganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pangkat-golongan-ext-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode') ?>

    <?= $form->field($model, 'pangkat') ?>

    <?= $form->field($model, 'golongan') ?>

    <?= $form->field($model, 'ruang') ?>

    <?php // echo $form->field($model, 'tingkat_sppd') ?>

    <?php // echo $form->field($model, 'uh_sppd_ld') ?>

    <?php // echo $form->field($model, 'uh_sppd_dd') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
