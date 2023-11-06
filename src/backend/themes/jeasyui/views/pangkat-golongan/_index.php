<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\PangkatGolonganAsset;

PangkatGolonganAsset::register($this);
?>
<div id="pangkat-golongan-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.pangkatGolongan.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
