<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;
use sheillendra\alpino\assets\BootstrapSelectAsset;

/* @var $this yii\web\View */
/* @var $model common\models\PelaksanaTugasExt */
/* @var $stid string */

BootstrapSelectAsset::register($this);
$assets = AlpinoAsset::register($this);

$this->title = $model->suratTugas->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Surat Tugas', 'url' => ['/surat-tugas']];
$this->params['breadcrumbs'][] = ['label' => 'Detail', 'url' => ['/surat-tugas/view', 'id' => $model->surat_tugas_id]];
$this->params['breadcrumbs'][] = 'Pelaksana Tugas';

$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'surat-tugas';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'pelaksana-tugas';
?>
<div class="pelaksana-tugas-create">
    <div class="row">
        <div class="col-md-4 d-none d-md-block">
            <?php echo $this->render('@app/views/surat-tugas/view_detail', ['model' => $model->suratTugas]) ?>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h2>Form Isian Pelaksana Tugas<small>*Isi pelaksana tugas</small></h2>
                </div>
                <div class="body">
                    <?php echo $this->render('_form', ['model' => $model,]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-md-none">
            <?php echo $this->render('@app/views/surat-tugas/view_detail', ['model' => $model->suratTugas]) ?>
        </div>
    </div>
</div>
