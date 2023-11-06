<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\JabatanDaerahExt */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Jabatan Daerah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'jabatan -daerah';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'jabatan -daerah';
?>
<div class="jabatan -daerah-view">
    <div class="card">
        <div class="header">
            <ul class="header-dropdown">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><?= Html::a('Update', ['update', 'id' => $model->id]) ?></li>
                        <li><?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'status',
                    'sort',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by',
                ],
            ]) ?>
        </div>
    </div>
</div>
