<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AnggaranRevisiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="anggaran-revisi-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> Revisi Anggaran<small>*Revisi anggaran ini tidak bisa diubah</small> </h2>

            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Tambah Revisi Anggaran', ['/anggaran-revisi/create', 'ai' => $model->id]) ?></li>
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
                    //[
                    //    // 'template' => '{view}',
                    //    'buttonOptions' => ['class' => 'btn btn-sm'],
                    //    'class' => 'sheillendra\alpino\grid\ActionColumn',
                    //],
                    //'id',
                    //'anggaran_id',
                    'saldo_awal:decimal',
                    'revisi:decimal',
                    'saldo_akhir:decimal',
                    'uraian',
                    'created_at:datetime',
                    'createdBy.username',
                //'updated_at',
                //'updated_by',
                ],
            ]);
            ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
