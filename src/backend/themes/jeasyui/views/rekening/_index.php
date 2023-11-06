<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\RekeningAsset;

RekeningAsset::register($this);
?>
<div id="rekening-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.rekening.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
