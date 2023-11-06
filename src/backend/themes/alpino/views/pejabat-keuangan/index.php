<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PejabatKeuanganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pejabat Keuangan';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'pejabat-keuangan';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'pejabat-keuangan';
?>
<div class="pejabat-keuangan-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Pejabat Keuangan<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Pejabat Keuangan', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive" style="min-height: 400px">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php
            echo GridView::widget([
                'tableOptions' => ['class' => 'table table-sm table-striped table-hover'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'template' => '{view}{generate-user}',
                        //'buttonOptions' => ['class' => 'btn btn-sm'],
                        'class' => 'sheillendra\alpino\grid\ActionColumn',
                        'buttons' => [
                            'generate-user' => function($url, $model) {
                                /* @var $model \common\models\PejabatKeuanganExt */
                                if ($model->pegawai->user_id) {
                                    return false;
                                }
                                return '&nbsp;&nbsp;' . Html::a(Html::tag('i', '', ['class' => 'zmdi zmdi-account']), $url
                                                , [
                                            'title' => 'Generate User',
                                            'data' => [
                                                'method' => 'post',
                                                'pjax' => 0,
                                                'confirm' => 'Yakin akan membuatkan user untuk pejabat ini?'
                                            ],
                                ]);
                            }
                        ]
                    ],
                    //'id',
                    'opd_id:opd',
                    [
                        'attribute' => 'jabatan_keuangan_id',
                        'value' => 'jabatanKeuangan.nama',
                        'filter' => Html::dropDownList('jabatan_keuangan_id'
                                , $searchModel->jabatan_keuangan_id
                                , common\models\JabatanKeuanganExt::dataList()
                                , [
                            'prompt' => 'Semua Jabatan',
                            'class' => 'form-control',
                            'data' => ['live-search' => 'true'],
                        ]),
                    ],
                    'pegawai_id:pegawai',
                    'tanggal_mulai:date',
                    'tanggal_selesai:date',
                //'dasar_hukum',
                //'status',
                //'keterangan:ntext',
                //'created_at',
                //'created_by',
                //'updated_at',
                //'updated_by',
                ],
            ]);
            ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
