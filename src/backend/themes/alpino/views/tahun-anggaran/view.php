<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\TahunAnggaranExt */

$this->title = 'Tahun Anggaran ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Tahun Anggaran', 'url' => ['/tahun-anggaran']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'tahun-anggaran';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'tahun-anggaran';
?>
<div class="tahun-anggaran-view">
    <div class="card">
        <div class="header">
            <h2>Detail <strong>Tahun Anggaran</strong><small>*Menampilkan data lebih lengkap</small> </h2>
            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Update', ['update', 'id' => $model->id]) ?></li>
                        <li><?php
                            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Yakin akan menghapus data ini??',
                                    'method' => 'post',
                                ],
                            ])
                            ?>
                        </li>
                        <li><?php echo Html::a('Tambah baru', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'tahun',
                    'status_anggaran:statusTahunAnggaran',
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
