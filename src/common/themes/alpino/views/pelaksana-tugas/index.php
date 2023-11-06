<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\BootstrapSelectAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PelaksanaTugasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$assets = BootstrapSelectAsset::register($this);
$this->params['assets'] = $assets;
$this->params['contentClass'] = 'pelaksana-tugas';
$this->title = 'Pelaksana Tugas';

$createParams = ['/pelaksana-tugas/create', 'stid' => $stid];
$url = Url::to(['/surat-tugas/view', 'id' => $stid], '');
$this->registerJs(<<<JS
            window.parent.history.pushState('view_surat_tugas_{$stid}', '{$this->title}', '{$url}');
JS
);
?>
<div class="pelaksana-tugas-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Pelaksana Tugas<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <?php if ($suratTugas->status === $suratTugas::STATUS_SEDANG_PROSES): ?>
                            <li><?php echo Html::a('Tambah Pelaksana Tugas', $createParams) ?></li>
                        <?php endif; ?>
                        <li><?php echo Html::a('Reload', 'javascript:window.parent.location.reload()') ?></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body table-responsive"style="min-height: 450px">
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
                        'urlCreator' => function ($action, $model, $key) {
                            /* @var $model \common\models\PelaksanaTugasExt */
                            return Url::to([$action, 'id' => $key, 'stid' => $model->surat_tugas_id], '');
                        },
                        'visibleButtons' => [
                            'delete' => function ($model, $key, $index) {
                                /* @var $model \common\models\PelaksanaTugasExt */
                                return (int)$model->suratTugas->status === common\models\SuratTugasExt::STATUS_SEDANG_PROSES;
                            }
                        ]
                    ],
                    //'id',
                    'pegawai.nama',
                    'status:statusPelaksanaTugas',
                    [
                        'label' => 'SPPD',
                        'format' => 'raw',
                        'value' => function($model) {
                            /* @var $model \common\models\PelaksanaTugasExt */
                            if ($model->suratTugas->status > \common\models\SuratTugasExt::STATUS_SEDANG_PROSES) {
                                if ($model->sppd) {
                                    $nomor = $model->sppd->nomor ?: 'Belum ada nomor';

                                    $url = 'javascript:window.parent.location=\''
                                            . Url::to(['/sppd/view', 'id' => $model->sppd->id], '') . '\'';
                                    return Html::a($nomor, $url, ['data' => ['pjax' => 0]]);
                                }
                                return null;
                            }
                        }
                    ],
                    //'urutan',
                    //'keterangan:ntext',
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
</div>
<?php
$urlPegawai = Yii::$app->urlManagerApi->createAbsoluteUrl(['/v1/pegawai'], true);
$this->registerJsFile('@web/js/ajax-bootstrap-select.min.js', ['depends' => ['sheillendra\alpino\assets\BootstrapSelectAsset']]);
$this->registerJs(<<<JS
    function initPegawaiFilter(){
        $('#pegawai_id_filter').selectpicker({
            liveSearch: true
        }).ajaxSelectPicker({
            ajax: {
                url: '{$urlPegawai}',
                type: 'get',
                dataType: 'json',
                data: function () {
                    var params = {
                        nama: '{{{q}}}'
                    };
                    return params;
                }
            },
            locale: {
                emptyTitle: 'Search for contact...'
            },
            preprocessData: function(data){
                var items = [];
                var len = data.length;
                for(var i = 0; i < len; i++){
                    var curr = data[i];
                    items.push(
                        {
                            'value': curr.id,
                            'text': curr.nama,
                            'data': {
                                'icon': 'icon-person',
                                'subtext': 'Internal'
                            },
                            'disabled': false
                        }
                    );
                }
                return items;
            },
            preserveSelected: false
        });
    };
    initPegawaiFilter();
    $(document).on('pjax:success', function(){
        initPegawaiFilter();
    });
JS
);
