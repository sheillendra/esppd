<?php

use yii\helpers\Html;
//use sheillendra\alpino\assets\AlpinoAsset;
use sheillendra\alpino\assets\BootstrapSelectAsset;

/* @var $this yii\web\View */
/* @var $model common\models\AnggaranExt */

$label = $model->opd->singkatan . ' ' . $model->tahunAnggaran->tahun;
$this->title = 'Update Anggaran: ' . $label;
$this->params['breadcrumbs'][] = ['label' => 'Anggaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $label, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$assets = BootstrapSelectAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'anggaran';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'anggaran';
?>
<div class="anggaran-update">
    <div class="card">
        <div class="header">
            <h2><strong>Form</strong> Update Anggaran<small>* Ketika anggaran sudah digunakan, tidak semua field bisa diupdate</small></h2>
        </div>
        <div class="body">
            <?php
            echo $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
