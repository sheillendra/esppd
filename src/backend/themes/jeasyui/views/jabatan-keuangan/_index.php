<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\JabatanKeuanganAsset;

JabatanKeuanganAsset::register($this);
?>
<div id="jabatan-keuangan-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.jabatanKeuangan.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
