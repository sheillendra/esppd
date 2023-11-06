<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EselonExt */

$this->title = 'Update Eselon Ext: ' . $model->kode;
$this->params['breadcrumbs'][] = ['label' => 'Eselon Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode, 'url' => ['view', 'id' => $model->kode]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="eselon-ext-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
