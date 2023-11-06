<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BesaranBiayaSppdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Besaran Biaya Sppd';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'besaran-biaya-sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'besaran-biaya-sppd';
?>
<div class="besaran-biaya-sppd-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Besaran Biaya Sppd<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah', ['create']) ?></li>
                        <li><?php echo Html::a('Non Aktifkan Semua', ['deactivated'], [
                                'data' => [
                                    'confirm' => 'Yakin akan menonaktifkan semua biaya yang aktif??',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

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
                    'tahun_anggaran',
                    'pangkat_golongan_id',
                    'eselon_id',
                    'jabatan_daerah_id',
                    'jabatan_struktural_id:jabatanStruktural',
                    //'jabatan_fungsional_id',
                    'kategori_wilayah:kategoriWilayah',
                    //'wilayah_id',
                    'jenis_biaya_sppd_id:jenisBiayaSppd',
                    'jumlah:decimal',
                    'status:active',
                    //'produk_hukum_id',
                    'keterangan:ntext',
                    'created_at:datetime',
                    'createdBy.username',
                    //'updated_at',
                    //'updated_by',

                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>