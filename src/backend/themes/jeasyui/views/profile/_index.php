<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\ProfileAsset;

ProfileAsset::register($this);
?>
<div id="profile-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.profile.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
