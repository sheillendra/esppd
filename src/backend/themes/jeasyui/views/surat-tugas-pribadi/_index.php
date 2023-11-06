<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\SuratTugasPribadiAsset;

SuratTugasPribadiAsset::register($this);
?>
<div id="surat-tugas-pribadi-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.suratTugasPribadi.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
