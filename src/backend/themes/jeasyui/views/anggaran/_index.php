<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\AnggaranAsset;

AnggaranAsset::register($this);
?>
<div id="anggaran-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.anggaran.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
