<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel asn\models\SppdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SPPD';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'sppd';
?>
<div class="sppd-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Sppd<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Sppd', ['create']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive" style="min-height: 450px">
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
                    //'anggaran_id',
                    //'pelaksana_tugas_id',
                    //'bendahara_pengeluaran_id',
                    //'pelaksana_teknik_kegiatan_id',
                    'nomor',
                    //'tanggal',
                    //'wilayah_berangkat',
                    //'wilayah_tujuan',
                    //'tanggal_berangkat',
                    //'tanggal_kembali',
                    //'tanggal_rampung',
                    //'alat_angkutan',
                    //'total_biaya',
                    //'saldo_awal',
                    //'saldo_akhir',
                    'status:statusSppd',
                    //'keterangan:ntext',
                    //'fix_tingkat_sppd',
                    //'fix_anggaran_opd',
                    //'fix_anggaran_opd_singkatan',
                    //'fix_pa_nama',
                    //'fix_pa_nip',
                    //'fix_bendahara_nama',
                    //'fix_bendahara_nip',
                    //'fix_teknik_nama',
                    //'fix_teknik_nip',
                    //'fix_penatausahaan_nama',
                    //'fix_penatausahaan_nip',
                    //'fix_kategori_wilayah',
                    //'pdf_filename_sppd_blank',
                    //'pdf_filename_sppd_barcode',
                    //'pdf_filename_sppd_ttd',
                    //'pdf_filename_visum_blank',
                    //'pdf_filename_visum_barcode',
                    //'pdf_filename_visum_ttd',
                    //'pdf_filename_biaya_blank',
                    //'pdf_filename_biaya_barcode',
                    //'pdf_filename_biaya_ttd',
                    //'pdf_filename_kwitansi_blank',
                    //'pdf_filename_kwitansi_barcode',
                    //'pdf_filename_kwitansi_ttd',
                    //'pdf_filename_riil_blank',
                    //'pdf_filename_riil_barcode',
                    //'pdf_filename_rill_ttd',
                    //'pdf_filename_rampung_blank',
                    //'pdf_filename_rampung_barcode',
                    //'pdf_filename_rampung_ttd',
                    //'created_at',
                    //'created_by',
                    //'updated_at',
                    //'updated_by',
                    //'total_bukti',
                    //'pdf_url_sppd_ttd:url',

                ],
            ]); ?>
            
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
