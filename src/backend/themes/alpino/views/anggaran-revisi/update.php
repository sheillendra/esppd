<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\AnggaranRevisiExt */

$this->title = 'Update Anggaran Revisi: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anggaran Revisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'anggaran-revisi';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'anggaran-revisi';
?>
<div class="anggaran-revisi-update">
    <div class="card">
        <div class="header">
            <h2><?php echo Html::encode($this->title) ?></h2>
        </div>
        <div class="body">
            <?php echo $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
