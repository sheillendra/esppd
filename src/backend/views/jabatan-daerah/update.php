<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\JabatanDaerahExt */

$this->title = 'Update Jabatan Daerah: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Jabatan Daerah', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'jabatan -daerah';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'jabatan -daerah';
?>
<div class="jabatan -daerah-update">
    <div class="card">
        <div class="header">
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
