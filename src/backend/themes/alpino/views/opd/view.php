<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\OpdExt */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Opd', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'opd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'opd';
?>
<div class="opd-view">
    <div class="card">
        <div class="header">
            <h2><strong>Detail</strong> Opd<small>*</small> </h2>
            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Update', ['update', 'id' => $model->id]) ?></li>
                        <li><?php echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Yakin akan menghapus data ini??',
                                'method' => 'post',
                            ],
                        ]) ?>
                        </li>
                        <li><?php echo Html::a('Tambah Baru', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'nama',
                    'induk_id:opd',
                    'status:active',
                    'baris_kop_1',
                    'baris_kop_2',
                    'kode_urusan',
                    'kode_bidang',
                    'kode_unit',
                    'kode_sub',
                    'keterangan:ntext',
                    'created_at:datetime',
                    'createdBy.username',
                    'updated_at:datetime',
                    'updatedBy.username',
                ],
            ]) ?>
        </div>
    </div>
</div>
