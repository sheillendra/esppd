<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\ProdukHukumAsset;

ProdukHukumAsset::register($this);
?>
<div id="produk-hukum-index" style="min-width: 1154px"></div>
<?php
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.produkHukum.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
