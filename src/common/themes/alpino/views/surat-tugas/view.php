<?php

use yii\helpers\Html;
use yii\helpers\Url;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\SuratTugasExt */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Surat Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'surat-tugas';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'surat-tugas';

$frameParams = Yii::$app->request->get('frame');
if ($frameParams === 'create') {
    $frameUrl = Url::to(['/pelaksana-tugas/create', 'stid' => $model->id]);
} else {
    $frameUrl = Url::to(['/pelaksana-tugas', 'stid' => $model->id]);
}
?>
<div class="surat-tugas-view">
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Detail</strong> Surat Tugas<small>*Informasi lebih lengkap</small> </h2>
                </div>
                <div class="body">
                    <?php
                    echo
                    DetailView::widget([
                        'model' => $model,
                        'options' => [],
                        'attributes' => [
                            //'id',
                            [
                                'label' => 'PDF',
                                'format' => 'raw',
                                'visible' => $model->status > 1,
                                'value' => function($model) {
                                    /* @var $model \common\models\SuratTugasExt */
                                    $html = [];
                                    $html[] = Html::a('<i class="zmdi zmdi-collection-pdf"></i> Belum TTD'
                                                    , Yii::$app->urlManagerFrontend->createAbsoluteUrl([
                                                        '/pdf/surat-tugas',
                                                        'id' => $model->pdfId([
                                                            'id' => $model->id,
                                                            'fn' => $model->pdf_filename_blank,
                                                            'type' => $model::PDF_TYPE_BLANK,
                                                        ])
                                                    ])
                                                    , ['target' => 'st_blank']);
                                    $html[] = Html::a('<i class="zmdi zmdi-collection-pdf"></i> Barcode'
                                                    , Yii::$app->urlManagerFrontend->createAbsoluteUrl([
                                                        '/pdf/surat-tugas',
                                                        'id' => $model->pdfId([
                                                            'id' => $model->id,
                                                            'fn' => $model->pdf_filename_barcode,
                                                            'type' => $model::PDF_TYPE_BARCODE,
                                                        ])
                                                    ])
                                                    , ['target' => 'st_blank']);
                                    if ($model->status === $model::STATUS_TERBIT) {
                                        $html[] = Html::a('<i class="zmdi zmdi-collection-pdf"></i> Sudah TTD'
                                                        , Yii::$app->urlManagerFrontend->createAbsoluteUrl([
                                                            '/pdf/surat-tugas',
                                                            'id' => $model->pdfId([
                                                                'id' => $model->id,
                                                                'fn' => $model->pdf_filename_ttd,
                                                                'type' => $model::PDF_TYPE_TTD,
                                                            ])
                                                        ])
                                                        , ['target' => 'st_blank']);
                                    }
                                    return implode('<br/>', $html);
                                }
                            ],
                            'status:statusSurat',
                            //'opd.nama',
                            'tanggal_terbit:date',
                            'nomor',
                            [
                                'attribute' => 'pejabatDaerah.jabatanDaerah.nama',
                                'visible' => $model->pejabat_daerah_id !== null
                            ],
                            [
                                'attribute' => 'pejabatStruktural.jabatanStruktural.nama',
                                'visible' => $model->pejabat_struktural_id !== null
                            ],
                            'maksud:ntext',
                            'tanggal_mulai:date',
                            'jumlah_hari:integer',
                            //'wilayahBerangkat.nama',
                            //'wilayahTujuan.nama',
                            'keterangan:ntext',
                            'created_at:datetime',
                            'createdBy.username',
                            'updated_at:datetime',
                            [
                                'attribute' => 'updatedBy.username',
                                'contentOptions' => ['class' => 'm-b-0'],
                            ]
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>
        <iframe src="<?php echo $frameUrl ?>" class="padding-0 border-0 col-lg-8 col-md-12" allowfullscreen style="min-height: 500px"></iframe>
    </div>
</div>
