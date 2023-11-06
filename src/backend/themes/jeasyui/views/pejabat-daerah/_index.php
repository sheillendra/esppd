<?php
/* @var $this yii\web\View */

use backend\themes\jeasyui\assets\PejabatDaerahAsset;

PejabatDaerahAsset::register($this);
?>
<div id="pejabat-daerah-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.pejabatDaerah.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
