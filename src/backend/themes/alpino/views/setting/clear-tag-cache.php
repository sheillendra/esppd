<?php

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $models yii2tech\config\Item[] */

$this->title = 'Clear Tag Dependency Cache';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'clear-tag-cache';
$this->render('@app/views/layouts/menus/setting', ['assets' => $assets]);
$this->params['contentClass'] = 'clear-tag-cache';
?>
<div class="sppd-update">
    <div class="card">
        <div class="header">
            <h2><?php echo Html::encode($this->title) ?><small>Cache ada salah satu metoda untuk meningkatkan kinerja aplikasi.</small></h2>
        </div>
        <div class="body">
            <div class="row">
                <?php
                $i = 1;
                foreach (\backend\models\InitialDataForm::TABLE_NAME as $table => $field):
                    ?>
                    <div class="col-sm-6 col-md-4"><?php
                        $table = Inflector::camel2words(Inflector::id2camel($table, '_'));
                        echo Html::a($i . '. ' . $table, ['/setting/invalidate-dependency'], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'method' => 'post',
                                'params' => ['tag' => $table],
                                'confirm' => strtr('Aksi ini akan membersihkan cache dengan tag {table}, lanjutkan?', ['{table}' => $table]),
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
