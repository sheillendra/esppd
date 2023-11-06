<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\RincianBiayaSppdExt */

$this->title = $model->uraian;
$this->params['breadcrumbs'][] = ['label' => 'SPPD', 'url' => ['/sppd']];
$this->params['breadcrumbs'][] = ['label' => 'Detail', 'url' => ['/sppd/view', 'id' => $model->sppd_id]];
$this->params['breadcrumbs'][] = 'Detail Biaya';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'rincian-biaya-sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'rincian-biaya-sppd';
?>
<div class="rincian-biaya-sppd-view">
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Detail</strong> SPPD<small>*Informasi lebih lengkap</small> </h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>                           
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <?php
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'sppd.nomor',
                            'jenisBiaya.nama',
                            'kategoriBiaya.nama',
                            'tanggal:date',
                            'uraian',
                            'volume',
                            'satuan_id:satuan',
                            'harga:decimal',
                            //'total:decimal',
                            //'total_bukti:decimal',
                            //'urutan',
                            'keterangan:ntext',
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
        <?php if ($model->riil): ?>
            <div class="col-lg-8 col-md-12">Biaya ini pengeluaran riil yang tidak ada bukti-bukti</div>
        <?php else: ?>
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Detail</strong> Biaya<small>*Bukti yang diupload</small> </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>                           
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <?php if ($model->pdf_bukti): ?>
                            <div class="form-group">
                                <label class="control-label">Uraian</label>
                                <div class="form-control"><?php echo $model->kategoriBiaya->nama, ': ', $model->uraian ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total</label>
                                <div class="form-control"><?php echo Yii::$app->formatter->asDecimal($model->total) ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total Bukti</label>
                                <div class="form-control"><?php echo Yii::$app->formatter->asDecimal($model->total_bukti) ?></div>
                            </div>
                        <?php else: ?>
                            <div>Bukti belum ada</div>
                        <?php endif; ?>
                    </div>
                </div>
                <iframe src="<?php echo Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd-bukti', 'id' => $model->id], '') ?>"
                        class="padding-0 border-0" allowfullscreen style="width: 100%;min-height: 450px">
                </iframe>
            </div>

        <?php endif; ?>
    </div>
</div>
