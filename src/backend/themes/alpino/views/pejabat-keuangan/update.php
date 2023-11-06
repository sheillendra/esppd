<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\PejabatKeuanganExt */

$this->title = 'Update Pejabat Keuangan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pejabat Keuangan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'pejabat-keuangan';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'pejabat-keuangan';
?>
<div class="pejabat-keuangan-update">
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
