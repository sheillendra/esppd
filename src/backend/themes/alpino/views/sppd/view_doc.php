<?php

use yii\helpers\Html;

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

echo $html;
