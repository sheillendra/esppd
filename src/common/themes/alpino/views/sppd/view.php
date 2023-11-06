<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */

$this->title = $model->nomor ?: 'Belum ada nomor';
$this->params['breadcrumbs'][] = ['label' => 'SPPD', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'sppd';
?>
<div class="sppd-view">
    <div class="row">
        <div class="col-lg-3 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Detail</strong> SPPD<small>*Informasi lebih lengkap</small> </h2>
                </div>
                <div class="body">
                    <?php
                    echo
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            [
                                'label' => 'PDF',
                                'format' => 'raw',
                                'visible' => $model->status >= $model::STATUS_HITUNG_BIAYA,
                                'value' => function($model) {
                                    /* @var $model \common\models\SppdExt */
                                    $html = Html::a('<i class="zmdi zmdi-collection-pdf"></i> SPPD Belum TTD'
                                                    , Yii::$app->urlManagerFrontend->createAbsoluteUrl([
                                                        '/pdf/sppd',
                                                        'id' => $model->pdfId([
                                                            'id' => $model->id,
                                                            'doc' => $model::DOC_SPPD,
                                                            'type' => $model::PDF_TYPE_BLANK,
                                                        ]),
                                                    ])
                                                    , ['target' => 'st_sppd_blank']) . '<br/>' .
                                            Html::a('<i class="zmdi zmdi-collection-pdf"></i> SPPD Barcode'
                                                    , Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd', 'id' => $model->pdfId(['id' => $model->id, 'doc' => 'sppd', 'type' => $model::PDF_TYPE_BARCODE])])
                                                    , ['target' => 'st_sppd_barcode']) . '<br/>' .
                                            Html::a('<i class="zmdi zmdi-collection-pdf"></i> Visum'
                                                    , Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd', 'id' => $model->pdfId(['id' => $model->id, 'doc' => 'visum', 'type' => $model::PDF_TYPE_BLANK])])
                                                    , ['target' => 'st_visum_blank']);
                                    if ($model->status >= $model::STATUS_PENGESAHAN) {
                                        $html .= '<br/>' . Html::a('<i class="zmdi zmdi-collection-pdf"></i> Biaya Belum TTD'
                                                        , Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd', 'id' => $model->pdfId(['id' => $model->id, 'doc' => 'biaya', 'type' => $model::PDF_TYPE_BLANK])])
                                                        , ['target' => 'st_biaya_blank']) .
                                                '<br/>' . Html::a('<i class="zmdi zmdi-collection-pdf"></i> Kwitansi Belum TTD'
                                                        , Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd', 'id' => $model->pdfId(['id' => $model->id, 'doc' => 'kwitansi', 'type' => $model::PDF_TYPE_BLANK])])
                                                        , ['target' => 'st_kwitansi_blank']);
                                    }

                                    if ($model->status === $model::STATUS_TERBIT) {
                                        $html .= '<br/>' . Html::a('<i class="zmdi zmdi-collection-pdf"></i> SPPD Sudah TTD'
                                                        , Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd', 'id' => $model->pdfId(['id' => $model->id, 'doc' => 'sppd', 'type' => $model::PDF_TYPE_TTD])])
                                                        , ['target' => 'st_sppd_ttd']);
                                    }

                                    if ($model->status === $model::STATUS_HITUNG_RAMPUNG) {
                                        $html .= '<br/>' . Html::a('<i class="zmdi zmdi-collection-pdf"></i> Daftar Riil Belum TTD'
                                                        , Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd', 'id' => $model->pdfId(['id' => $model->id, 'doc' => 'riil', 'type' => $model::PDF_TYPE_BLANK])])
                                                        , ['target' => 'st_riil_blank']);
                                        $html .= '<br/>' . Html::a('<i class="zmdi zmdi-collection-pdf"></i> Rampung Belum TTD'
                                                        , Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd', 'id' => $model->pdfId(['id' => $model->id, 'doc' => 'rampung', 'type' => $model::PDF_TYPE_BLANK])])
                                                        , ['target' => 'st_rampung_blank']);
                                    }
                                    return $html;
                                }
                            ],
                            'status:statusSppd',
                            'nomor',
                            [
                                'label' => 'No. Surat Tugas',
                                'format' => 'raw',
                                'value' => function($model) {
                                    /* @var $model common\models\SppdExt */
                                    return Html::a($model->pelaksanaTugas->suratTugas->nomor, [
                                                '/surat-tugas/view',
                                                'id' => $model->pelaksanaTugas->suratTugas->id
                                    ]);
                                }
                            ],
                            [
                                'attribute' => 'anggaran_id',
                                'format' => 'raw',
                                'value' => function($model) {
                                    /* @var $model common\models\SppdExt */
                                    if ($model->anggaran) {
                                        return Html::a($model->anggaran->kode_rekening, [
                                                    '/anggaran/view',
                                                    'id' => $model->anggaran->id
                                        ]);
                                    }
                                },
                            ],
                            [
                                'attribute' => 'pelaksana_tugas_id',
                                'format' => 'raw',
                                'value' => function($model) {
                                    /* @var $model common\models\SppdExt */
                                    if ($model->pelaksanaTugas->pegawai) {
                                        $html = Html::a($model->pelaksanaTugas->pegawai->nama_tanpa_gelar, ['/pegawai/view', 'id' => $model->pelaksanaTugas->pegawai_id]);
                                    } else {
                                        $html = Html::a($model->pelaksanaTugas->penduduk->nama_tanpa_gelar, ['/penduduk/view', 'id' => $model->pelaksanaTugas->penduduk_id]);
                                    }
                                    return $html;
                                },
                            ],
                            'tanggal',
                            'wilayahBerangkat.nama',
                            'wilayahTujuan.nama',
                            'tanggal_berangkat',
                            'tanggal_kembali',
                            'alat_angkutan',
                            'keterangan:ntext',
                            //'pdf_url_blank:url',
                            //'pdf_url_barcode:url',
                            //'pdf_url_ttd:url',
                            //'pdf2_url_blank:url',
                            //'pdf2_url_barcode:url',
                            //'pdf2_url_ttd:url',
                            //'pdf3_url_blank:url',
                            //'pdf3_url_barcode:url',
                            //'pdf3_url_ttd:url',
                            //'pdf4_url_blank:url',
                            //'pdf4_url_barcode:url',
                            //'pdf4_url_ttd:url',
                            //'pdf5_url_blank:url',
                            //'pdf5_url_barcode:url',
                            //'pdf5_url_ttd:url',
                            //'pdf6_url_blank:url',
                            //'pdf6_url_barcode:url',
                            //'pdf6_url_ttd:url',
                            //'pdf7_url_blank:url',
                            //'pdf7_url_barcode:url',
                            //'pdf7_url_ttd:url',
                            'created_at:datetime',
                            'createdBy.username',
                            'updated_at:datetime',
                            'updatedBy.username',
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Rincian</strong> Biaya<small>*Untuk memulai menghitung biaya, status SPPD harus diubah menjadi "<?php echo $model::LABEL_STATUS[$model::STATUS_HITUNG_BIAYA] ?>"</small> </h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <?php echo $this->render('view_rincian-biaya', ['model' => $model, 'items' => $items]) ?>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
