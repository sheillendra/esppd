<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TahunAnggaranExt */

$this->title = 'Update Tahun Anggaran Ext: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tahun Anggaran Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tahun-anggaran-ext-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
