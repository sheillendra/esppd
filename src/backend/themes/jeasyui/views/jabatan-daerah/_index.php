<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\JabatanDaerahAsset;

JabatanDaerahAsset::register($this);
?>
<div id="jabatan-daerah-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.jabatanDaerah.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
