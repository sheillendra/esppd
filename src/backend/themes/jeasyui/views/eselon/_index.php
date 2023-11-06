<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\EselonAsset;

EselonAsset::register($this);
?>
<div id="eselon-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.eselon.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
