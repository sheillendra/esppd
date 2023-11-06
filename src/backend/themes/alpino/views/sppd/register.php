<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */

$this->title = 'Register';
$this->params['breadcrumbs'][] = ['label' => 'Sppd', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Register';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'sppd';
?>
<div class="sppd-update">
    <div class="card">
        <div class="header">
            <h2><?php echo Html::encode($this->title) ?></h2>
        </div>
        <div class="body">
            <?php echo $this->render('_form-register', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
