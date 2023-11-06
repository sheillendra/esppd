<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\PendudukExt */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Penduduk', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'penduduk';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'penduduk';
?>
<div class="penduduk-view">
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Detail <strong>Penduduk</strong><small>Data lebih lengkap</small></h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><?php echo Html::a('Update', ['update', 'id' => $model->id]) ?></li>
                                <li><?php
                                    echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                                        'data' => [
                                            'confirm' => 'Yakin akan menghapus data ini??',
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                </li>
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
                            [
                                'attribute' => 'nik',
                            ],
                            'nama',
                            'jenis_kelamin:gender',
                            'status:active',
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
    </div>
</div>
