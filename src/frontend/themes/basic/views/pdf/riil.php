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
                <tr><td style="text-align: center; font-size: 18px;font-weight: bold">DAFTAR PENGELUARAN RIIL</td></tr>
                <tr><td style="border-bottom: 4px solid; border-bottom-style: double;font-size: 6px">&nbsp;</td></tr>
                <tr><td style="font-size: 8px;">&nbsp;</td></tr>
                <tr><td>Yang bertanda tangan di bawah ini: </td></tr>
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
                                <td>Nip</td>
                                <td>:</td>
                                <td><?php echo $model->pelaksanaTugas->fix_nip ?></td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td><?php echo $model->pelaksanaTugas->fix_jabatan ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td style="font-size: 8px;">&nbsp;</td></tr>
                <tr><td>Berdasarkan Surat Perintah Perjalanan Dinas (SPPD) Nomor: <?php echo $model->nomor ?> tanggal <?php echo \common\components\helpers\DateFormat::id($model->tanggal) ?> dengan ini menyatakan dengan sesungguhnya bahwa: </td></tr>
                <tr><td style="font-size: 6px">&nbsp;</td></tr>
                <tr><td>1. Biaya-biaya berikut ini yang tidak dapat diperoleh bukti-bukti pengeluarannya meliputi: </td></tr>
                <tr><td style="font-size: 6px">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr style="text-align: center">
                                    <th style="width:1%">No.</th>
                                    <th>Uraian</th>
                                    <th>Satuan</th>
                                    <th>Vol</th>
                                    <th>Harga Satuan</th>
                                    <th style="width:10%">Jumlah</th>
                                    <th style="max-width: 20%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach (KategoriBiayaSppdExt::dataList() as $k => $v):
                                    ?>
                                    <?php if (isset($items[$k])): ?>
                                        <?php
                                        $noUrut = 1;
                                        $subtotal = 0;
                                        foreach ($items[$k]['row'] as $kk => $vv):
                                            if (!$vv['riil']) {
                                                continue;
                                            }
                                            ?>
                                            <?php if ($noUrut === 1): ?>
                                                <tr style="background-color: darkgray">
                                                    <th style="text-align: center"><?php echo chr(64 + $k) ?>.</th>
                                                    <th><?php echo $v ?></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td></td>
                                                <td style="white-space: nowrap;max-width: 50%"><?php
                                                    echo $noUrut . '.&nbsp;&nbsp;' .
                                                    Yii::$app->formatter->asDate($vv['tanggal'], 'd/M/Y') . '&nbsp;&nbsp;&nbsp;' .
                                                    $vv['uraian']
                                                    ?>
                                                </td>
                                                <td><?php echo $vv['nama_satuan'] ?></td>
                                                <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($vv['volume']) ?></td>
                                                <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($vv['harga']) ?></td>
                                                <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($vv['total']) ?></td>
                                                <td><?php echo $vv['keterangan'] ?></td>
                                            </tr>
                                            <?php
                                            $noUrut++;
                                            $subtotal += $vv['total'];
                                        endforeach;
                                        $total += $subtotal;
                                        ?>
                                        <?php if ($subtotal > 0): ?>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align: right">Subtotal</th>
                                                <th style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($subtotal) ?></th>
                                                <th></th>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php
                                endforeach;
                                ?>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: right">Total</th>
                                    <th style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($total) ?></th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr><td style="font-size: 6px">&nbsp;</td></tr>
                <tr><td style="text-indent: -12px;padding-left: 12px">2. Jumlah uang tersebut pada angka 1 di atas benar-benar dikeluarkan untuk pelaksanaan perjalanan dinas dimaksud dan apabila dikemudian hari terdapat kelebihan atas pembayaran, kami bersedia untuk menyetor kelebihan tersebut ke Kas Daerah.</td></tr>
                <tr><td style="font-size: 6px">&nbsp;</td></tr>
                <tr><td>Demikian pernyataan ini kami buat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.</td></tr>
                <tr><td style="height: 20px;">&nbsp;</td></tr>
                <tr>
                    <td>
                        <table border="0" style="width: 100%">
                            <tr>
                                <td style="height: 10px; width: 50%">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="text-align: center">
                                <td></td>
                                <td><?php echo $suratTugas->fix_opd_kedudukan ?>, <?php echo DateFormat::id($model->tanggal_rampung); ?></td>
                            </tr>
                            <tr style="text-align: center">
                                <td>Mengetahui / Menyetujui,</td>
                                <td></td>
                            </tr>
                            <tr style="text-align: center">
                                <td>Pejabat Pelaksana Teknik Kegiatan</td>
                                <td>Pelaksana SPPD</td>
                            </tr>
                            <tr>
                                <td style="height: 70px">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="text-align: center; font-weight: bold; text-decoration: underline">
                                <td>
                                    <?php echo $model->fix_teknik_nama ?>
                                </td>
                                <td><?php echo $model->pelaksanaTugas->fix_nama ?></td>
                            </tr>
                            <tr style="text-align: center">
                                <td><?php echo $model->fix_teknik_nip ?></td>
                                <td>NIP. <?php echo $model->pelaksanaTugas->fix_nip ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>