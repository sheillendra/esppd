<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\JabatanStrukturalExt */
/* @var $get Array */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Jabatan Struktural', 'url' => array_merge(['index'], $get)];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'jabatan-struktural';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'jabatan-struktural';
?>
<div class="jabatan-struktural-view">
    <div class="card">
        <div class="header">
            <h2><strong>Detail</strong> Jabatan Struktural<small>*Informasinya lebih lengkap</small></h2>
            <?php echo $this->render('@app/views/_partials/_view-btn', ['model' => $model]) ?>
        </div>
        <div class="body">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'opd_id:opd',
                    'nama',
                    //'nama_2',
                    //'singkatan',
                    'tingkat_sppd',
                    'status:active',
                    //'urutan',
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
