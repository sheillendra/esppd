<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\BesaranBiayaSppdAsset;

BesaranBiayaSppdAsset::register($this);
?>
<div id="besaran-biaya-sppd-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.besaranBiayaSppd.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
