<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\BootstrapSelectAsset;
use common\models\OpdExt;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuratTugasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Surat Tugas';
$this->params['breadcrumbs'][] = $this->title;

$assets = BootstrapSelectAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'surat-tugas';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'surat-tugas';
?>
<div class="surat-tugas-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Surat Tugas<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Surat Tugas', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive" style="min-height: 400px">
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
                    'nomor',
//                    [
//                        'attribute' => 'nomor',
//                        'format' => 'html',
//                        'value' => function($model) {
//                            return Html::a($model->nomor, ['view', 'id' => $model->id]);
//                        }
//                    ],
                    'tanggal_terbit:date',
                    //'opd_id:opd',
                    //'pejabat_daerah_id',
                    //'pejabat_struktural_id',
                    [
                        'label' => 'Perintah Dari',
                        'attribute' => 'pejabat_daerah_id',
                        'value' => function($model) {
                            /* @var $model \common\models\SuratTugasExt */
                            return $model->pejabat_daerah_id ? $model->pejabatDaerah->jabatanDaerah->nama :
                                    $model->pejabatStruktural->jabatanStruktural->nama;
                        },
                        'filter' => Html::dropDownList('SuratTugasSearch[pejabat_daerah_id]'
                                , $searchModel->pejabat_daerah_id ? $searchModel->pejabat_daerah_id : ($searchModel->pejabat_struktural_id + 500)
                                , $searchModel->dataListPejabatPemerintah()
                                , [
                            'prompt' => 'Semua jabatan', 'id' => 'filter_pemerintah'
                            , 'data' => ['live-search' => true]
                        ])
                    ],
                    //'jumlah_hari',
                    'status:statusSurat',
                    'maksud:ntext',
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

<?php
$this->registerJs(<<<JS
        $(document).on('pjax:success', function(){
            $('#filter_pemerintah').selectpicker();
        });
JS
);
