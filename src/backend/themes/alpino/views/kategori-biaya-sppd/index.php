<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\KategoriBiayaSppdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategori Biaya Sppd';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'kategori-biaya-sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'kategori-biaya-sppd';
?>
<div class="kategori-biaya-sppd-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Kategori Biaya Sppd<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Kategori Biaya Sppd', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        
            <?php echo GridView::widget([
                'tableOptions' => ['class' => 'table table-sm table-striped table-hover'],
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
                    'nama',
                    'status:active',
                    //'urutan',
                    'keterangan:ntext',
                    //'created_at',
                    //'created_by',
                    //'updated_at',
                    //'updated_by',

                ],
            ]); ?>
            
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
