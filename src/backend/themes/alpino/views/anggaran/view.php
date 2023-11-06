<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\AnggaranExt */

$this->title = $model->opd->singkatan . ' ' . $model->tahunAnggaran->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Anggaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'anggaran';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'anggaran';
?>
<div class="anggaran-view">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="header">
                    <h2><strong>Detail</strong> Anggaran<small>Rincian Lengkap</small></h2>
                    <?php echo $this->render('@app/views/_partials/_view-btn', ['model' => $model]) ?>
                </div>
                <div class="body">
                    <?php
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'opd_id:opd',
                            'tahun_anggaran_id:tahunAnggaran',
                            'kode_rekening',
                            'jumlah:decimal',
                            'saldo:decimal',
                            'kegiatan:ntext',
                            'keterangan:ntext',
                            'status:active',
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
        <div class="col-md-5">
            <div class="card">
                <div class="header">
                    <h2>Daftar <strong>SPPD</strong><small>SPPD yang menggunakan anggaran ini</small></h2>
                </div>
                <div class="body table-responsive">
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?php
                    echo GridView::widget([
                        'tableOptions' => ['class' => 'table table-sm table-striped table-hover'],
                        'dataProvider' => $sppdDataProvider,
                        'filterModel' => $sppdSearchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'template' => '{view}',
                                'class' => 'sheillendra\alpino\grid\ActionColumn',
                                'controller' => 'sppd',
                            ],
                            'saldo_awal:decimal',
                            'total_biaya:decimal',
                            'saldo_akhir:decimal',
                            'nomor',
                        ],
                    ]);
                    ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->render('@app/views/anggaran-revisi/index', [
                'model' => $model,
                'searchModel' => $revisiSearchModel,
                'dataProvider' => $revisiDataProvider,
            ])
            ?>
        </div>
    </div>
</div>
