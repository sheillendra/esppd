<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */
/* @var $form common\widgets\ActiveForm */
?>

<div class="sppd-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $form->field($model, 'opd_id')->opdDropdownList([
        'prompt' => 'Pilih OPD'
    ])
    ?>

    <?php echo $form->field($model, 'dari_tanggal')->dateInput() ?>

        <?php echo $form->field($model, 'sampai_tanggal')->dateInput() ?>

    <div class="form-group">
        <?php
        echo Html::submitButton('Cari', [
            'class' => 'btn btn-success'
        ])
        ?>
    </div>

<?php ActiveForm::end(); ?>

</div>