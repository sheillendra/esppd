<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PangkatGolonganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pangkat Golongan';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'pangkat-golongan';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'pangkat-golongan';
?>
<div class="pangkat-golongan-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Pangkat Golongan<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Pangkat Golongan', ['create']) ?></li>
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

                    'kode',
                    'pangkat',
                    'golongan',
                    'ruang',
                    'tingkat_sppd',
                    'status:active',
                    'keterangan:ntext',
                    //'created_at:datetime',
                    //'createdBy.username',
                    //'updated_at:datetime',
                    //'updatedBy.username',

                ],
            ]); ?>
            
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
