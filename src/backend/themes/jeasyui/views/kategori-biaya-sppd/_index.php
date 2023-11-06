<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\KategoriBiayaSppdAsset;

KategoriBiayaSppdAsset::register($this);
?>
<div id="kategori-biaya-sppd-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.kategoriBiayaSppd.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
