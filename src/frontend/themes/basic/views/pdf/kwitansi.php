<?php
/* @var $model \common\models\SppdExt */

use common\components\helpers\DateFormat;
use common\components\helpers\Number;
use common\models\RincianBiayaSppdExt;

$suratTugas = $model->pelaksanaTugas->suratTugas;

$items = RincianBiayaSppdExt::findBiayaBySppd($model->id);

$timeTanggal = strtotime($model->tanggal);
?>
<html>
    <body>
        <style>
            @page {
                margin: 1cm;
                padding: 0;
                size: A4;
                font-size: 14px;
            }
            body {
                font-family: TimesNewRoman, "Times New Roman", Times, Tahoma, sans-serif;
                text-align: justify;
                background-position: right bottom;
                background-repeat: no-repeat;
            }
        </style>
        <div style="margin-right: 0">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                <tr>
                    <td>
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 15%">No. Bukti</td>
                                <td style="width: 1%">:</td>
                                <td>&nbsp;</td>
                                <td style="width: 15%">Mata Anggaran</td>
                                <td style="width: 1%">:</td>
                                <td style="width: 20%; border-bottom: 1px solid; border-top: 1px solid"><?php echo $model->anggaran->kode_rekening ?></td>
                            </tr>
                            <tr>
                                <td>Lembar</td>
                                <td>:</td>
                                <td>I / II / III / IV / V / VI / VII / VIII</td>
                                <td>Bulan</td>
                                <td>:</td>
                                <td style="border-bottom: 1px solid"><?php echo DateFormat::MONTH_TEXT[(int) date('m', $timeTanggal)]; ?></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Tahun</td>
                                <td>:</td>
                                <td style="border-bottom: 1px solid"><?php echo date('Y', $timeTanggal); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="height: 20px;">&nbsp;</td></tr>
                <tr><td style="text-align: center; font-size: 18px;font-weight: bold">KWITANSI</td></tr>
                <tr><td style="height: 20px;">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 20%">Sudah terima dari</td>
                                <td style="width: 1%">:</td>
                                <td style="border-top: 1px solid;border-bottom: 1px solid;">Bendahara Pengeluaran <?php echo $model->fix_anggaran_opd_singkatan ?></td>
                            </tr>
                            <tr>
                                <td>Uang sejumlah</td>
                                <td>:</td>
                                <td style="border-bottom: 1px solid;font-weight: bold"><?php echo ucwords(Number::indonesianWords($model->total_biaya)) ?> Rupiah</td>
                            </tr>
                            <tr style="vertical-align: top">
                                <td>Untuk pembayaran</td>
                                <td>:</td>
                                <td style="border-bottom: 1px solid;">Biaya Perjalanan Dinas <?php echo $model->fix_kategori_wilayah ?> dalam rangka <?php echo $suratTugas->maksud ?> atas nama : <?php echo $model->pelaksanaTugas->fix_nama ?></td>
                            </tr>
                            <tr><td>&nbsp;</td><td></td><td></td></tr>
                            <tr>
                                <td>Terbilang</td>
                                <td>:</td>
                                <td>
                                    <table><tr><td style="font-weight: bold;border-bottom: 2px solid; border-bottom-style: double">Rp. <?php echo Yii::$app->formatter->asDecimal($model->total_biaya) ?></td></tr></table></td>
                            </tr>
                            <tr><td>&nbsp;</td><td></td><td></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" style="width: 100%">
                            <tr style="text-align: center">
                                <td style="width: 33%">Lunas dibayar,</td>
                                <td style="width: 34%">Setuju dibayar,</td>
                                <td style="width: 33%">Yang Menerima,</td>
                            </tr>
                            <tr style="text-align: center">
                                <td>Bendahara Pengeluaran</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="height: 70px">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="text-align: center; font-weight: bold; text-decoration: underline">
                                <td><?php echo $model->fix_bendahara_nama ?></td>
                                <td><?php echo $model->fix_pa_nama ?></td>
                                <td><?php echo $model->pelaksanaTugas->fix_nama ?></td>
                            </tr>
                            <tr style="text-align: center">
                                <td>NIP. <?php echo $model->fix_bendahara_nip ?></td>
                                <td>NIP. <?php echo $model->fix_pa_nip ?></td>
                                <td>NIP. <?php echo $model->pelaksanaTugas->fix_nip ?></td>
                            </tr>
                            <tr>
                                <td style="height: 30px">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Dibayar</td>
                                <td></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Tgl</td>
                                <td></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="height: 10px; border-bottom: 1px solid; border-bottom-style: dashed;">&nbsp;</td>
                                <td style="border-bottom: 1px solid; border-bottom-style: dashed">&nbsp;</td>
                                <td style="border-bottom: 1px solid; border-bottom-style: dashed">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>