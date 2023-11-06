<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\AnggaranRevisiExt */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anggaran Revisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'anggaran-revisi';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'anggaran-revisi';
?>
<div class="anggaran-revisi-view">
    <div class="card">
        <div class="header">
            <h2><strong>Detail</strong> Revisi Anggaran<small>*Informasinya lebih lengkap</small></h2>
            <?php echo $this->render('@app/views/_partials/_view-btn', ['model' => $model]) ?>
        </div>
        <div class="body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'anggaran_id',
                    'uraian',
                    'saldo_awal:decimal',
                    'revisi:decimal',
                    'saldo_akhir:decimal',
                    'created_at:datetime',
                    'createdBy.username',
                    'updated_at:datetime',
                    'updatedBy.username',
                ],
            ]) ?>
        </div>
    </div>
</div>
