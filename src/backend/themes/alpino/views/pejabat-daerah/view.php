<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\PejabatDaerahExt */

$this->title = $model->jabatanDaerah->nama_2;
$this->params['breadcrumbs'][] = ['label' => 'Pejabat Daerah', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'pejabat-daerah';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'pejabat-daerah';
?>
<div class="pejabat-daerah-view">
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Detail <strong>Pejabat Daerah</strong><small>Data lebih lengkap</small></h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <?php if ($model->penduduk->user_id): ?>
                                    <li><?php echo Html::a('Detail User', ['/user/view', 'id' => $model->penduduk->user_id]) ?></li>
                                <?php else: ?>
                                    <li><?php echo Html::a('Generate User', ['generate-user', 'id' => $model->id], ['data' => ['method' => 'post']]) ?></li>
                                <?php endif; ?>
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
                            'jabatanDaerah.nama',
                            'penduduk.nama',
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
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h2>Daftar <strong>SPPD</strong><small>SPPD pegawai</small></h2>
                </div>
                <div class="body table-responsive">
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?php
                    echo GridView::widget([
                        'tableOptions' => ['class' => 'table table-sm table-striped table-hover'],
                        'dataProvider' => $sppdDataProvider,
                        'filterModel' => $sppdSearchModel,
                        'showFooter' => true,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'template' => '{view}',
                                'class' => 'sheillendra\alpino\grid\ActionColumn',
                                'controller' => 'sppd',
                            ],
                            'nomor',
                            [
                                'attribute' => 'status',
                                'format' => 'statusSppd',
                                'footer' => 'Total:',
                                'footerOptions' => ['style' => 'text-align:right; font-weight: bold']
                            ],
                            [
                                'attribute' => 'total_bukti',
                                'format' => 'decimal',
                                'footer' => Yii::$app->formatter->asDecimal($sppdSearchModel->getTotal($sppdDataProvider->models, 'total_bukti')),
                                'footerOptions' => ['style' => 'text-align:right; font-weight: bold']
                            ],
                        ],
                    ]);
                    ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
