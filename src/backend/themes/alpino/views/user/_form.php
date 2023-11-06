<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'status')->dropDownList($model::STATUS_LABEL) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
