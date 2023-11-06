<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TahunAnggaranExt */

$this->title = 'Create Tahun Anggaran Ext';
$this->params['breadcrumbs'][] = ['label' => 'Tahun Anggaran Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tahun-anggaran-ext-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
