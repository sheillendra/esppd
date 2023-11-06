<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\BootstrapSelectAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PendudukSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penduduk';
$this->params['breadcrumbs'][] = $this->title;

$assets = BootstrapSelectAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'penduduk';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'penduduk';
?>
<div class="penduduk-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Penduduk<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Penduduk', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive">
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
                        'template' => '{view}&nbsp;&nbsp{generate-user}',
                        //    'buttonOptions' => ['class' => 'btn btn-sm'],
                        'class' => 'sheillendra\alpino\grid\ActionColumn',
                        'buttons' => [
                            'generate-user' => function($url, $model) {
                                /* @var $model \common\models\PendudukExt */
                                if ($model->user && $model->user->can(\common\models\UserExt::ROLE_PENDUDUK)) {
                                    return Html::a(Html::tag('i', ''
                                                            , ['class' => 'zmdi zmdi-account'])
                                                    , ['/user/view', 'id' => $model->user_id]
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
                    //'id:penduduk',
                    'gelar_depan',
                    'nama_tanpa_gelar',
                    'gelar_belakang',
                    'nik',
                    'jenis_kelamin:gender',
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
