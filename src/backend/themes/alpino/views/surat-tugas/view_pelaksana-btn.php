<?php

use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $model common\models\SuratTugasExt */

$items = [];
if ($model->status === $model::STATUS_SEDANG_PROSES) {
    $items[] = [
        'label' => 'Tambah Pelaksana Tugas',
        'url' => ['/pelaksana-tugas/create', 'stid' => $model->id],
    ];
}

if ($items) {
    ?>
    <ul class="header-dropdown">
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
            <?php
            echo Menu::widget([
                'options' => ['class' => 'dropdown-menu dropdown-menu-right'],
                'items' => $items
            ]);
            ?>
        </li>
    </ul><?php
}

