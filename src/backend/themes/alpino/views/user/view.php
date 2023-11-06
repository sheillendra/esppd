<?php

use sheillendra\alpino\widgets\DetailView;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\UserExt */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Detail';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'user';
$this->render('@app/views/layouts/menus/user', ['assets' => $assets]);
$this->params['contentClass'] = 'user';
?>
<div class="user-view">
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Detail <strong>User</strong><small>Data lebih lengkap</small></h2>
                    <?php echo $this->render('view_detail-btn', ['model' => $model])?>
                </div>
                <div class="body">
                    <?php
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'namaLink:raw:Nama',
                            'opd:raw:OPD',
                            'username',
                            'allRoles',
                            'email:email',
                            'status:statusUser',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-12">

            </div>
        </div>
    </div>
</div>
