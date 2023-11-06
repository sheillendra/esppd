<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\SppdAsset;
use common\models\SppdExt;

SppdAsset::register($this);
?>
<div id="sppd-index" style="min-width: 1154px"></div>
<div id="sppd-tb" class="datagrid-toolbar">
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div id="sppd-tb-hapus"></div>
            </td>
            <td>
                <div id="sppd-tb-pdf"></div>
                <div id="sppd-tb-pdf-mm" style="width:150px;"></div>
            </td>
        </tr>
    </table>
</div>
<div id="sppd-doc-tb" class="datagrid-toolbar">
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div id="sppd-doc-tb-generate"></div>
            </td>
            <td>
                <div id="sppd-doc-tb-upload"></div>
            </td>
        </tr>
    </table>
</div>
<?php
$statusSedangProses =  SppdExt::STATUS_SEDANG_PROSES;
$statusHitungBiaya =  SppdExt::STATUS_HITUNG_BIAYA;
$statusPengesahan =  SppdExt::STATUS_PENGESAHAN;
$statusTerbit =  SppdExt::STATUS_TERBIT;
$statusHitungRampung =  SppdExt::STATUS_HITUNG_RAMPUNG;
$statusDibatalkan =  SppdExt::STATUS_DIBATALKAN;
$this->registerJs(<<<JS
    yii.easyui.tabInit = function(){
        yii.app.sppd.STATUS_SEDANG_PROSES = $statusSedangProses;
        yii.app.sppd.STATUS_HITUNG_BIAYA = $statusHitungBiaya;
        yii.app.sppd.STATUS_PENGESAHAN = $statusPengesahan;
        yii.app.sppd.STATUS_TERBIT = $statusTerbit;
        yii.app.sppd.STATUS_HITUNG_RAMPUNG = $statusHitungRampung;
        yii.app.sppd.STATUS_DIBATALKAN = $statusDibatalkan;
        yii.app.sppd.init();
        yii.easyui.hideMainMask();
    };
JS
        , $this::POS_END);
