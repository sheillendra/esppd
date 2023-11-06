<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use backend\themes\jeasyui\assets\SuratTugasAsset;
use common\models\SuratTugasExt;

SuratTugasAsset::register($this);
?>
<div id="surat-tugas-index" style="min-width: 1154px"></div>
<div id="surat-tugas-tb" class="datagrid-toolbar">
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div id="surat-tugas-tb-baru"></div>
            </td>
            <td>
                <div id="surat-tugas-tb-edit"></div>
            </td>
            <td>
                <div id="surat-tugas-tb-hapus"></div>
            </td>
            <td>
                <div id="surat-tugas-tb-pdf"></div>
                <div id="surat-tugas-tb-pdf-mm" style="width:150px;"></div>
            </td>
        </tr>
    </table>
</div>
<div id="surat-tugas-doc-tb" class="datagrid-toolbar">
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div id="surat-tugas-doc-tb-generate"></div>
            </td>
            <td>
                <div id="surat-tugas-doc-tb-upload"></div>
            </td>
        </tr>
    </table>
</div>
<?php
$sedangProses = SuratTugasExt::STATUS_SEDANG_PROSES;
$pengesahan = SuratTugasExt::STATUS_PENGESAHAN;
$terbit = SuratTugasExt::STATUS_TERBIT;
$this->registerJs(
    <<<JS
    yii.easyui.tabInit = function(){
        yii.app.suratTugas.STATUS_SEDANG_PROSES = $sedangProses;
        yii.app.suratTugas.STATUS_PENGESAHAN = $pengesahan;
        yii.app.suratTugas.STATUS_TERBIT = $terbit;
        yii.app.suratTugas.init();
        yii.easyui.hideMainMask();
    };
JS,
    $this::POS_END
);
