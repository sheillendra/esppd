<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\JabatanStrukturalAsset;

JabatanStrukturalAsset::register($this);
?>
<div id="jabatan-struktural-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.jabatanStruktural.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
