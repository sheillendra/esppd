<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\SatuanExt */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Satuan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'satuan';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'satuan';
?>
<div class="satuan-view">
    <div class="card">
        <div class="header">
            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?php echo Html::a('Update', ['update', 'id' => $model->id]) ?></li>
                        <li><?php echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Yakin akan menghapus data ini??',
                                'method' => 'post',
                            ],
                        ]) ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'nama',
                    'status',
                    'keterangan:ntext',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by',
                ],
            ]) ?>
        </div>
    </div>
</div>
