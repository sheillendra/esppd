<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SppdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $rf string */

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
            <h2><strong>Daftar</strong> SPPD<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Register SPPD', ['register']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php
            echo GridView::widget([
                'tableOptions' => ['class' => 'table table-sm table-striped table-hover'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'template' => '{view}',
                        // 'buttonOptions' => ['class' => 'btn btn-sm'],
                        'class' => 'sheillendra\alpino\grid\ActionColumn',
                    ],
                    //'id',
                    //'anggaran_id',
//                    [
//                        'attribute' => 'pelaksana_tugas_id',
//                        'value' => function($model) {
//                            /* @var $model \common\models\SppdExt */
//                            if ($model->pelaksanaTugas->pegawai_id) {
//                                return $model->pelaksanaTugas->pegawai->nama_tanpa_gelar;
//                            }
//                            return $model->pelaksanaTugas->penduduk->nama_tanpa_gelar;
//                        }
//                    ],
                    'pelaksana_tugas_id:pelaksanaTugas',
                    'status:statusSppd',
                    'nomor',
                    'pelaksanaTugas.suratTugas.nomor',
                    'tanggal',
                //'wilayah_berangkat',
                //'wilayah_tujuan',
                //'tanggal_berangkat',
                //'tanggal_kembali',
                //'alat_angkutan',
                //'status',
                //'keterangan:ntext',
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
if ($rf) {
    $urlSheet = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/sheet/register-sppd', 'id' => $rf, 'time' => $time], '');
    $this->registerJs(<<<JS
            window.open('{$urlSheet}', 'registerfile');
JS
    );
}