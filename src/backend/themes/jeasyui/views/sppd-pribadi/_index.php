<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\SppdPribadiAsset;

SppdPribadiAsset::register($this);
?>
<div id="sppd-pribadi-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.sppdPribadi.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
