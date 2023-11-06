<?php
/* @var $this yii\web\View */

use backend\themes\jeasyui\assets\WilayahAsset;

WilayahAsset::register($this);
?>
<div id="wilayah-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.wilayah.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
