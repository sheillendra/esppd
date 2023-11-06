<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PangkatGolonganExt */

$this->title = 'Create Pangkat Golongan Ext';
$this->params['breadcrumbs'][] = ['label' => 'Pangkat Golongan Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pangkat-golongan-ext-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
