<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JabatanDaerahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jabatan Daerah';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'jabatan-daerah';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'jabatan-daerah';
?>
<div class="jabatan-daerah-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Jabatan Daerah<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?= Html::a('Tambah Jabatan Daerah', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        
            <?php echo GridView::widget([
                'tableOptions' => ['class' => 'table table-sm table-striped'],
                'dataProvider' => $dataProvider,
                'pager' => [
                    'pageCssClass' => 'btn btn-sm btn-neutral',
                    'activePageCssClass' => 'btn btn-sm btn-neutral',
                    'disabledPageCssClass' => 'btn btn-sm btn-neutral',
                    'prevPageCssClass' => 'btn btn-sm btn-neutral',
                    'nextPageCssClass' => 'btn btn-sm btn-neutral',
                ],
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        // 'template' => '{view}',
                        'buttonOptions' => ['class' => 'btn btn-sm'],
                        'class' => 'sheillendra\alpino\grid\ActionColumn',
                    ],

                    'id',
                    'name',
                    'status',
                    'sort',
                    'created_at',
                    //'created_by',
                    //'updated_at',
                    //'updated_by',

                ],
            ]); ?>
            
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
