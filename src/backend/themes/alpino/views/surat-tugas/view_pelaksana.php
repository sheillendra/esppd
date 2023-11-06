<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use common\grid\GridView;
use common\models\SuratTugasExt;
use common\models\PelaksanaTugasExt;

/* @var $this yii\web\View */
/* @var $model SuratTugasExt */
?>
<div class="card">
    <div class="header">
        <h2><strong>Pelaksana </strong> Tugas<small>*Dalam satu surat bisa lebih dari satu petugas</small> </h2>
        <?php echo $this->render('view_pelaksana-btn', ['model' => $model]) ?>
    </div>
    <div class="body table-responsive">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-sm table-striped'],
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'template' => '{delete}',
                    'class' => 'sheillendra\alpino\grid\ActionColumn',
                    'controller' => 'pelaksana-tugas',
                    'visibleButtons' => [
                        'delete' => function ($model, $key, $index) {
                            /* @var $model PelaksanaTugasExt */
                            return (int) $model->suratTugas->status === SuratTugasExt::STATUS_SEDANG_PROSES &&
                                    $model->status === $model::STATUS_BELUM_SPPD;
                        }
                    ]
                ],
                //'id',
                [
                    'attribute' => 'namaPelaksana',
                    'format' => 'raw',
                    'value' => function($model) {
                        /* @var $model PelaksanaTugasExt */
                        return Html::a($model->namaPelaksana, $model->pegawai_id ? 
                                ['/pegawai/view', 'id' => $model->pegawai_id] : 
                            ['/penduduk/view', 'id' => $model->penduduk_id], ['data' => ['pjax' => 0]]);
                    }
                ],
                'status:statusPelaksanaTugas',
                [
                    'label' => 'SPPD',
                    'format' => 'raw',
                    'value' => function($model) {
                        /* @var $model PelaksanaTugasExt */
                        if ($model->sppd) {
                            $nomor = $model->sppd->nomor ?:
                                    'Belum ada nomor';
                            return Html::a($nomor, [
                                        '/sppd/view',
                                        'id' => $model->sppd->id
                                            ], ['data' => ['pjax' => 0]
                            ]);
                        }

                        if ($model->suratTugas->status >
                                SuratTugasExt::STATUS_SEDANG_PROSES) {
                            return Html::a('Buat SPPD', [
                                        '/sppd/generate',
                                        'ptid' => $model->id
                                            ], ['data' => ['pjax' => 0]]
                            );
                        }
                        return null;
                    }
                ],
                //'urutan',
                'keterangan:ntext',
                'created_at:datetime',
                'createdBy.username',
                'updated_at:datetime',
                'updatedBy.username',
            ],
        ]);
        ?>

        <?php Pjax::end(); ?>
    </div>
</div>