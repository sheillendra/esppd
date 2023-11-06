<?php

use yii\helpers\Url;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\SuratTugasExt */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Surat Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'surat-tugas';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'surat-tugas';

$frameParams = Yii::$app->request->get('frame');
if ($frameParams === 'create') {
    $frameUrl = Url::to(['/pelaksana-tugas/create', 'stid' => $model->id]);
} else {
    $frameUrl = Url::to(['/pelaksana-tugas', 'stid' => $model->id]);
}
?>
<div class="surat-tugas-view">
    <div class="row">
        <div class="col-md-4">
            <?php echo $this->render('view_detail', ['model' => $model]) ?>
        </div>
        <div class="col-md-8">
            <?php
            echo $this->render('view_pelaksana', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ])
            ?>
        </div>
    </div>
</div>
