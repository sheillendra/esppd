<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */
?>
<div class="card">
    <div class="header">
        <h2><strong>Detail</strong> SPPD<small>*Informasi lebih lengkap</small> </h2>
        <?php echo $this->render('view_detail-btn', ['model' => $model]) ?>
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
                        /* @var $this yii\web\View */
                        return $this->render('view_doc', ['model' => $model]);
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
                            return Html::a($model->anggaran->nama, [
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
                'pelaksanaTugas.suratTugas.maksud',
                'tanggal',
                'wilayahBerangkat.nama',
                'wilayahTujuan.nama',
                'tanggal_berangkat',
                'tanggal_kembali',
                'alat_angkutan',
                'keterangan:ntext',
                'fix_pa_nama',
                'fix_teknik_nama',
                'fix_bendahara_nama',
                'fix_penatausahaan_nama',
                'created_at:datetime',
                'createdBy.username',
                'updated_at:datetime',
                'updatedBy.username',
            ],
        ])
        ?>
    </div>
</div>