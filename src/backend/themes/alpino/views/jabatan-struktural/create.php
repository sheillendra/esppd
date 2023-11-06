<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\JabatanStrukturalExt */

$this->title = 'Tambah Jabatan Struktural';
$this->params['breadcrumbs'][] = ['label' => 'Jabatan Struktural', 'url' => array_merge(['index'], $get)];
$this->params['breadcrumbs'][] = 'Tambah';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'jabatan-struktural';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'jabatan-struktural';
?>
<div class="jabatan-struktural-create">
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
