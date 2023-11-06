<?php
/* @var $this yii\web\View */

use backend\themes\jeasyui\assets\PendudukAsset;

PendudukAsset::register($this);
?>
<div id="penduduk-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.penduduk.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
