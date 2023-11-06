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
                <tr><td style="text-align: center; font-size: 18px;font-weight: bold">REKAPITULASI BIAYA PERJALANAN DINAS</td></tr>
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
                                    <th style="width:10%">Jumlah</th>
                                    <th style="max-width: 20%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach (KategoriBiayaSppdExt::dataList() as $k => $v):
                                    ?>
                                    <tr style="background-color: darkgray">
                                        <th style="text-align: center"><?php echo chr(64 + $k) ?>.</th>
                                        <th><?php echo $v ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <?php if (isset($items[$k])): ?>
                                        <?php
                                        $noUrut = 1;
                                        $subtotal = 0;
                                        foreach ($items[$k]['row'] as $kk => $vv):
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td style="white-space: nowrap;max-width: 50%"><?php
                                                    echo $noUrut . '.&nbsp;&nbsp;' .
                                                    Yii::$app->formatter->asDate($vv['tanggal'], 'd/M/Y') . '&nbsp;&nbsp;&nbsp;' .
                                                    Yii::$app->formatter->asDecimal($vv['volume']) . '&nbsp;' .
                                                    $vv['nama_satuan'] . '&nbsp;x&nbsp;' .
                                                    Yii::$app->formatter->asDecimal($vv['harga']) . '&nbsp;&nbsp;&nbsp;' .
                                                    $vv['uraian']
                                                    ?>
                                                </td>
                                                <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($vv['total']) ?></td>
                                                <td><?php echo $vv['keterangan'] ?></td>
                                            </tr>
                                            <?php
                                            $noUrut++;
                                            $subtotal += $vv['total'];
                                        endforeach;
                                        $total += $subtotal;
                                        ?>
                                        <tr>
                                            <th></th>
                                            <th style="text-align: right">Subtotal</th>
                                            <th style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($subtotal) ?></th>
                                            <th></th>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td></td>
                                            <td>-</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php
                                endforeach;
                                ?>
                                <tr>
                                    <th></th>
                                    <th style="text-align: right">Total</th>
                                    <th style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($total) ?></th>
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
                                <td style="width: 50%">Telah dibayar uang sejumlah</td>
                                <td style="width: 50%">Telah diterima uang sejumlah</td>
                            </tr>
                            <tr style="text-align: center">
                                <td style="font-weight: bold; text-decoration: underline;">Rp. <?php echo Yii::$app->formatter->asDecimal($total) ?></td>
                                <td style="font-weight: bold; text-decoration: underline;">Rp. <?php echo Yii::$app->formatter->asDecimal($total) ?></td>
                            </tr>
                            
                            <tr>
                                <td style="height: 10px">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="text-align: center">
                                <td>Bendahara Pengeluaran</td>
                                <td>Penerima</td>
                            </tr>
                            <tr>
                                <td style="height: 70px">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="text-align: center; font-weight: bold; text-decoration: underline">
                                <td>
                                    <?php echo $model->fix_bendahara_nama ?>
                                </td>
                                <td><?php echo $model->pelaksanaTugas->fix_nama ?></td>
                            </tr>
                            <tr style="text-align: center">
                                <td>NIP. <?php echo $model->fix_bendahara_nip ?></td>
                                <td>NIP. <?php echo $model->pelaksanaTugas->fix_nip ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>