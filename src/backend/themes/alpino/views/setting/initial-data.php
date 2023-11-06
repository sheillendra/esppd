<?php

use yii\helpers\ArrayHelper;
use common\widgets\ActiveForm;
use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $models yii2tech\config\Item[] */

$this->title = 'Data awal';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'initial-data';
$this->render('@app/views/layouts/menus/setting', ['assets' => $assets]);
$this->params['contentClass'] = 'initial-data';
?>
<div class="sppd-update">
    <div class="card">
        <div class="header">
            <h2><?php echo Html::encode($this->title) ?><small>Uplod file .xlsx yang berisi data awal, harus sesuai format standar, download file standarnya di sini.</small></h2>
        </div>
        <div class="body">
            <?php $form = ActiveForm::begin(); ?>
            <?php echo $form->field($model, 'fileInit')->fileInput() ?>
            <div class="form-group">
                <?php echo Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
