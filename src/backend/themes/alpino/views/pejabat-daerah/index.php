<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PejabatDaerahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pejabat Daerah';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'pejabat-daerah';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'pejabat-daerah';
?>
<div class="pejabat-daerah-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Pejabat Daerah<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Pejabat Daerah', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php
            echo GridView::widget([
                'tableOptions' => ['class' => 'table table-sm table-striped'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'template' => '{view}&nbsp;&nbsp;{generate-user}',
                        //    'buttonOptions' => ['class' => 'btn btn-sm'],
                        'class' => 'sheillendra\alpino\grid\ActionColumn',
                        'buttons' => [
                            'generate-user' => function($url, $model) {
                                /* @var $model \common\models\PejabatDaerahExt */
                                if ($model->penduduk->user_id && $model->penduduk->user->can(\common\models\UserExt::ROLE_PEJABAT_DAERAH)) {
                                    return Html::a(Html::tag('i', ''
                                                            , ['class' => 'zmdi zmdi-account'])
                                                    , ['/user/view', 'id' => $model->penduduk->user_id]
                                                    , ['style' => 'color:blue']
                                    );
                                }
                                return Html::a(Html::tag('i', '', ['class' => 'zmdi zmdi-account']), $url
                                                , [
                                            'title' => 'Generate User',
                                            'data' => [
                                                'method' => 'post',
                                                'pjax' => 0,
                                                'confirm' => 'Yakin akan membuatkan user untuk penduduk ini?'
                                            ],
                                ]);
                            }
                        ]
                    ],
                    //'id',
                    'jabatan_daerah_id:jabatanDaerah',
                    'penduduk_id:penduduk',
                    'tanggal_mulai:date',
                    'tanggal_selesai:date',
                    //'dasar_hukum',
                    'status:active',
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
