<?php
/* @var $this yii\web\View */

use backend\themes\jeasyui\assets\OpdAsset;

OpdAsset::register($this);
?>
<div id="opd-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.opd.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
