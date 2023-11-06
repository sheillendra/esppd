<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\JabatanKeuanganExt */

$this->title = 'Tambah Jabatan Keuangan';
$this->params['breadcrumbs'][] = ['label' => 'Jabatan Keuangan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'jabatan-keuangan';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'jabatan-keuangan';
?>
<div class="jabatan-keuangan-create">
    <div class="card">
        <div class="header">
            <h2><?php echo Html::encode($this->title) ?></h2>
        </div>
        <div class="body">
            <?php echo $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
