<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\RincianBiayaSppdExt */

$this->title = 'Update Rincian Biaya Sppd';
$this->params['breadcrumbs'][] = ['label' => 'SPPD', 'url' => ['/sppd/index']];
$this->params['breadcrumbs'][] = ['label' => 'Detail SPPD', 'url' => ['/sppd/view', 'id' => $model->sppd_id]];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Upload bukti';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'sppd';
?>
<div class="rincian-biaya-sppd-upload">
    <div class="card">
        <div class="header">
            <h2><?php echo Html::encode($this->title) ?></h2>
        </div>
        <div class="body">
            <?php echo $this->render('_form_upload', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>