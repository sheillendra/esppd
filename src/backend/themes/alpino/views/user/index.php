<?php

use yii\helpers\Html;
use common\grid\GridView;
use yii\widgets\Pjax;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'user';
$this->render('@app/views/layouts/menus/user', ['assets' => $assets]);
$this->params['contentClass'] = 'user';
?>
<div class="user-index">
    <div class="card">
        <div class="header">
            <h2><strong>Daftar</strong> User<small>*Isian yang ada di atas setiap kolom dalam daftar adalah isian pencarian</small> </h2>
        </div>
        <div class="body table-responsive">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php
            echo GridView::widget([
                'tableOptions' => ['class' => 'table table-sm table-striped table-hover'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'template' => '{view}{reset-password}',
                        //    'buttonOptions' => ['class' => 'btn btn-sm'],
                        'class' => 'sheillendra\alpino\grid\ActionColumn',
                        'buttons' => [
                            'reset-password' => function($url, $model) {
                                /* @var $model \common\models\UserExt */
                                if (Yii::$app->user->id === $model->id) {
                                    return false;
                                }
                                return '&nbsp;&nbsp;' . Html::a(Html::tag('i', '', ['class' => 'zmdi zmdi-lock'])
                                                , $url
                                                , [
                                            'title' => 'Reset password',
                                            'data' => [
                                                'method' => 'post',
                                                'pjax' => 0,
                                                'confirm' => 'Anda yakin akan mereset password user ini?'
                                            ],
                                ]);
                            }
                        ]
                    ],
                    //'id',
                    'username',
                    //'auth_key',
                    //'password_hash',
                    //'password_reset_token',
                    //'email:email',
//                    [
//                        'attr'
//                        'value' => function($model, $key, $id) {
//                            /* @var $model \common\models\UserExt */
//                            $result = '';
//                            if ($model->pegawaiAsProfile) {
//                                $result = $model->pegawaiAsProfile->nama;
//                            }
//                            return $result;
//                        }
//                    ],
                    'nama_lengkap',
                    'roles',
                    //'status',
                    'created_at:datetime',
                //'updated_at',
                //'verification_token',
                ],
            ]);
            ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
