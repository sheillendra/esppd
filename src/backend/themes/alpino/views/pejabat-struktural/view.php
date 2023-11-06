<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\PejabatStrukturalExt */

$this->title = $model->jabatanStruktural->nama;
$this->params['breadcrumbs'][] = ['label' => 'Pejabat Struktural', 'url' => ['/pejabat-struktural']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'pejabat-struktural';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'pejabat-struktural';
?>
<div class="pejabat-struktural-view">
    <div class="card">
        <div class="header">
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
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'jabatanStruktural.nama',
                    'pegawai_id:pegawai',
                    'tanggal_mulai:date',
                    'tanggal_selesai:date',
                    'dasar_hukum',
                    'status:active',
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
