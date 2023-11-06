<?php
/* @var $model \common\models\SppdExt */

use common\models\KategoriBiayaSppdExt;
use common\models\RincianBiayaSppdExt;
use common\components\helpers\DateFormat;

$suratTugas = $model->pelaksanaTugas->suratTugas;

$items = RincianBiayaSppdExt::findBiayaBySppd($model->id);
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
                <tr><td style="text-align: center; font-size: 18px;font-weight: bold">PERHITUNGAN SPPD RAMPUNG</td></tr>
                <tr><td style="border-bottom: 4px solid; border-bottom-style: double;font-size: 6px">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                            <tr style="font-size: 6px;">
                                <td style="width: 20%">&nbsp;</td>
                                <td style="width: 1%">&nbsp;</td>
                                <td style="width: 69%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><?php echo $model->pelaksanaTugas->fix_nama ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><?php echo DateFormat::id($model->tanggal_berangkat) ?></td>
                            </tr>
                            <tr>
                                <td>Nomor SPPD</td>
                                <td>:</td>
                                <td><?php echo $model->nomor ?></td>
                            </tr>
                            <tr>
                                <td>Nomor ST</td>
                                <td>:</td>
                                <td><?php echo $suratTugas->nomor ?></td>
                            </tr>
                            <tr>
                                <td>Tujuan</td>
                                <td>:</td>
                                <td><?php echo $model->wilayahTujuan->nama ?></td>
                            </tr>
                            <tr style="vertical-align: top">
                                <td>Maksud</td>
                                <td>:</td>
                                <td><?php echo $suratTugas->maksud ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah hari</td>
                                <td>:</td>
                                <td><?php echo $suratTugas->jumlah_hari ?> hari</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="font-size: 6px">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="width:1%">No.</th>
                                    <th>Uraian</th>
                                    <th style="width:10%">Panjar</th>
                                    <th style="width:10%">Bukti</th>
                                    <th style="width:10%; white-space: nowrap;">Sisa</th>
                                    <th style="max-width: 20%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalPanjar = 0;
                                $totalBukti = 0;
                                $totalSisa = 0;
                                $noUrut = 1;
                                foreach (KategoriBiayaSppdExt::dataList() as $k => $v):
                                    $jumlahPanjar = 0;
                                    $jumlahBukti = 0;
                                    $sisa = 0;
                                    $keterangan = '';
                                    if (isset($items[$k])) {
                                        foreach ($items[$k]['row'] as $kk => $vv) {
                                            $jumlahPanjar += $vv['total'];
                                            if ($vv['riil']) {
                                                $jumlahBukti += $vv['total'];
                                                $keterangan = 'Daftar Pengeluaran Riil';
                                            } else {
                                                $jumlahBukti += $vv['total_bukti'];
                                                $keterangan = 'Real cost';
                                            }
                                        }
                                        $sisa = $jumlahPanjar - $jumlahBukti;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $noUrut ?>.</td>
                                        <td><?php echo $v ?></td>
                                        <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($jumlahPanjar) ?></td>
                                        <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($jumlahBukti) ?></td>
                                        <td style="text-align: right; white-space: nowrap;"><?php echo Yii::$app->formatter->asDecimal($sisa) ?></td>
                                        <td><?php echo $keterangan ?></td>
                                    </tr>
                                    <?php
                                    $noUrut++;
                                    $totalPanjar += $jumlahPanjar;
                                    $totalBukti += $jumlahBukti;
                                    $totalSisa += $sisa;
                                endforeach;
                                ?>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($totalPanjar) ?></th>
                                    <th style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($totalBukti) ?></th>
                                    <th style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($totalSisa) ?></th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr><td style="height: 20px;">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table border="0" style="width: 100%">
                            <tr style="text-align: center">
                                <td style="width: 50%">&nbsp;</td>
                                <td><?php echo $suratTugas->fix_opd_kedudukan ?>, <?php echo DateFormat::id($model->tanggal_rampung); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="height: 20px;">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 70%">
                            <tr><td colspan="5">Berdasarkan hasil verifikasi bukti-bukti pengeluaran biaya perjalanan dinas sebagaimana tersebut di atas, dapat dirinci sebagai berikut : </td></tr>
                            <tr>
                                <td style="width: 1%">1.</td>
                                <td style="white-space: nowrap;">Telah menerima uang sejumlah</td>
                                <td style="width: 1%; white-space: nowrap;">: Rp. </td>
                                <td style="width: 10%; white-space: nowrap; text-align: right;"><?php echo Yii::$app->formatter->asDecimal($totalPanjar) ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Bukti pengeluaran</td>
                                <td style="white-space: nowrap; border-bottom: 1px solid">: Rp. </td>
                                <td style="text-align: right; white-space: nowrap; border-bottom: 1px solid"><?php echo Yii::$app->formatter->asDecimal($totalBukti) ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Sisa yang harus disetor/ditambah</td>
                                <td style="white-space: nowrap;">: Rp. </td>
                                <td style="text-align: right; white-space: nowrap;"><?php echo Yii::$app->formatter->asDecimal($totalSisa) ?></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="height: 20px;">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table border="0" style="width: 100%">
                            <tr style="text-align: center">
                                <td>Penerima</td>
                                <td>Pejabat Penatausahaan Keuangan</td>
                            </tr>
                            <tr>
                                <td style="height: 70px">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="text-align: center; font-weight: bold; text-decoration: underline">
                                <td>
                                    <?php echo $model->pelaksanaTugas->fix_nama ?>
                                </td>
                                <td><?php echo $model->fix_penatausahaan_nama ?></td>
                            </tr>
                            <tr style="text-align: center">
                                <td>NIP. <?php echo $model->pelaksanaTugas->fix_nip ?></td>
                                <td>NIP. <?php echo $model->fix_penatausahaan_nip ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="height: 20px">&nbsp;</td></tr>
                <tr style="text-align: center"><td>Mengetahui,</td></tr>
                <tr style="text-align: center"><td><?php echo $suratTugas->fix_jabatan ?></td></tr>
                <tr style="text-align: center"><td><?php echo Yii::$app->params['pemerintahTtd'] ?></td></tr>
                <tr><td style="height: 70px">&nbsp;</td></tr>
                <tr style="text-align: center; font-weight: bold; text-decoration: underline">
                    <td><?php echo $model->fix_pa_nama ?></td>
                </tr>
                <tr style="text-align: center">
                    <td><?php echo $model->fix_pa_nip ?></td>
                </tr>
            </table>
        </div>
    </body>
</html>