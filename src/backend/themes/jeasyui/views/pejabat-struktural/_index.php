<?php
/* @var $this yii\web\View */

use backend\themes\jeasyui\assets\PejabatStrukturalAsset;

PejabatStrukturalAsset::register($this);
?>
<div id="pejabat-struktural-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.pejabatStruktural.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
