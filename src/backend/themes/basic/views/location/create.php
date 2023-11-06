<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EselonExt */

$this->title = 'Create Eselon Ext';
$this->params['breadcrumbs'][] = ['label' => 'Eselon Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eselon-ext-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
