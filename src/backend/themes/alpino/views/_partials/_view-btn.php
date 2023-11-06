<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\JabatanStrukturalExt */
/* @var $get Array */
$get = Yii::$app->request->get();
unset($get['id']);
?>
<ul class="header-dropdown">
    <li class="dropdown">
        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><?php echo Html::a('Update', array_merge(['update', 'id' => $model->id], $get)) ?></li>
            <li><?php
                echo Html::a('Hapus', array_merge(['delete', 'id' => $model->id], $get), [
                    'data' => [
                        'confirm' => 'Yakin akan menghapus data ini??',
                        'method' => 'post',
                    ],
                ])
                ?>
            </li>
            <li><?php echo Html::a('Tambah Baru', ['create']) ?></li>
        </ul>
    </li>
</ul>