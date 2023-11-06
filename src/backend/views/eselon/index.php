<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EselonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eselon Exts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eselon-ext-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Eselon Ext', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode',
            'eselon',
            'pangkat_min',
            'pangkat_max',
            'tingkat_sppd',
            //'uh_sppd_ld',
            //'uh_sppd_dd',
            //'urep_sppd_ld',
            //'urep_sppd_dd',
            //'description:ntext',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
