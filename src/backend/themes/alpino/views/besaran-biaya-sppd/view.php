<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\BesaranBiayaSppdExt */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Besaran Biaya Sppd', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'besaran-biaya-sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'besaran-biaya-sppd';
?>
<div class="besaran-biaya-sppd-view">
    <div class="card">
        <div class="header">
            <h2><strong>Detail</strong> Besaran Biaya SPPD<small>*Informasinya lebih lengkap</small></h2>
            <?php echo $this->render('@app/views/_partials/_view-btn', ['model' => $model]) ?>
        </div>
        <div class="body">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'pangkatGolongan.pangkat',
                    ['attribute' => 'eselon_id', 'visible' => !empty($model->eselon_id)],
                    'jabatanDaerah.nama',
                    'jabatanStruktural.nama',
                    //'jabatan_fungsional_id',
                    'kategori_wilayah:kategoriWilayah',
                    //'wilayah_id',
                    'jenisBiayaSppd.nama',
                    'jumlah:decimal',
                    'status:active',
                    'produkHukum.nama',
                    'keterangan:ntext',
                    'created_at:datetime',
                    'createdBy.username',
                    'updated_at:datetime',
                    'updatedBy.username',
                ],
            ])
            ?>
        </div>
    </div>
</div>
