<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\PegawaiAsset;

PegawaiAsset::register($this);
?>
<div id="pegawai-index" style="min-width: 1154px"></div>
<?php
$formUrl = Url::to(['/product', 'form' => 1]);
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.pegawai.formUrl = '{$formUrl}';
        yii.app.pegawai.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
