<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EselonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eselon-ext-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'kode') ?>

    <?= $form->field($model, 'eselon') ?>

    <?= $form->field($model, 'pangkat_min') ?>

    <?= $form->field($model, 'pangkat_max') ?>

    <?= $form->field($model, 'tingkat_sppd') ?>

    <?php // echo $form->field($model, 'uh_sppd_ld') ?>

    <?php // echo $form->field($model, 'uh_sppd_dd') ?>

    <?php // echo $form->field($model, 'urep_sppd_ld') ?>

    <?php // echo $form->field($model, 'urep_sppd_dd') ?>

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
