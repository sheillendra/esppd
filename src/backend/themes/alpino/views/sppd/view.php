<?php

use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */

$this->title = $model->nomor ?: 'Belum ada nomor';
$this->params['breadcrumbs'][] = ['label' => 'SPPD', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'sppd';
?>
<div class="sppd-view">
    <div class="row">
        <div class="col-lg-3 col-md-12">
            <?php echo $this->render('view_detail', ['model' => $model]) ?>
        </div>
        <div class="col-lg-9 col-md-12">
            <?php echo $this->render('view_rincian-biaya', ['model' => $model, 'items' => $items]) ?>    
        </div>
    </div>
</div>
