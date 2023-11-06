<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\JabatanStrukturalExt */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Jabatan Struktural', 'url' => array_merge(['index'], $get)];
$this->params['breadcrumbs'][] = ['label' => 'Detail', 'url' => array_merge(['view', 'id' => $model->id], $get)];
$this->params['breadcrumbs'][] = 'Update';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'jabatan-struktural';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'jabatan-struktural';
?>
<div class="jabatan-struktural-update">
    <div class="card">
        <div class="header">
            <h2><?php echo'Form update' ?></h2>
        </div>
        <div class="body">
            <?php echo $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
