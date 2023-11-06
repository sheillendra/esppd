<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\AnggaranRevisiExt */

$this->title = 'Tambah Revisi Anggaran';
$this->params['breadcrumbs'][] = ['label' => 'Anggaran', 'url' => ['/anggaran']];
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'anggaran-revisi';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'anggaran-revisi';
?>
<div class="anggaran-revisi-create">
    <div class="card">
        <div class="header">
            <h2>Form Revisi</h2>
        </div>
        <div class="body">
            <?php echo $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
