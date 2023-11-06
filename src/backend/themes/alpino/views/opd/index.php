<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OpdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'OPD';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'opd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'opd';
?>
<div class="opd-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Opd<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Opd', ['create']) ?></li>
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
                        'template' => '{view}',
                        //'buttonOptions' => ['class' => 'btn btn-sm'],
                        'class' => 'sheillendra\alpino\grid\ActionColumn',
                    ],
                    //'id',
                    //'kode_urusan',
                    //'kode_bidang',
                    //'kode_unit',
                    //'kode_sub',
//                    [
//                        'attribute' => 'kode_urusan',
//                        'label' => 'Kode',
//                        'value' => function($model) {
//                            return $model->kode_urusan . '.' .
//                                    $model->kode_bidang . '.' .
//                                    $model->kode_unit . '.' .
//                                    $model->kode_sub;
//                        }
//                    ],
                    [
                        'attribute' => 'nama',
                        'format' => 'html',
                        'value' => function($model) {
                            return Html::tag('div', $model->nama, ['class' => 'text-truncate', 'style' => 'max-width:500px']);
                        }
                    ],
                    'induk_id:opd',
                //'nama',
                'status:active',
                //'baris_kop_1',
                //'baris_kop_2',
                'keterangan:ntext',
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
