<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\PejabatStrukturalExt */

$this->title = 'Update Pejabat Struktural';
$this->params['breadcrumbs'][] = ['label' => 'Pejabat Struktural', 'url' => ['/pejabat-struktural']];
$this->params['breadcrumbs'][] = ['label' => 'Detail', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'pejabat-struktural';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'pejabat-struktural';
?>
<div class="pejabat-struktural-update">
    <div class="card">
        <div class="header">
            <h2><?php echo 'Form ', Html::encode($this->title) ?></h2>
        </div>
        <div class="body">
            <?php echo $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
