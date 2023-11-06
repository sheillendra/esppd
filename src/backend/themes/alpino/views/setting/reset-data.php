<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $models yii2tech\config\Item[] */

$this->title = 'Reset Data';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'reset-data';
$this->render('@app/views/layouts/menus/setting', ['assets' => $assets]);
$this->params['contentClass'] = 'reset-data';
?>
<div class="sppd-update">
    <div class="card">
        <div class="header">
            <h2><?php echo Html::encode($this->title) ?><small>Uplod file .xlsx yang berisi data awal, harus sesuai format standar, download file standarnya di sini.</small></h2>
        </div>
        <div class="body">
            <div class="row">
                <?php
                $i = 1;
                foreach (\backend\models\InitialDataForm::TABLE_NAME as $table => $field):
                    ?>
                    <div class="col-sm-6 col-md-4"><?php
                        $table = Inflector::camel2words(Inflector::id2camel($table, '_'));
                        echo Html::a($i . '. ' . $table, ['/setting/reset-data'], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'method' => 'post',
                                'params' => ['table' => $table],
                                'confirm' => strtr('Yakin akan menghapus data {table}? INGAT!!! aksi ini akan menghapus data dan seluruh data turunannya', ['{table}' => $table]),
                            ],
                        ]);
                        ?>
                    </div><?php
                    $i++;
                endforeach;
                ?>
            </div>
            <div class="row">

            </div>
        </div>
    </div>
</div>
