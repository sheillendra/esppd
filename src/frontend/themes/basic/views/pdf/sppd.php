<?php

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

/* @var $model \common\models\SppdExt */

$qrCodeFilename = $path . DIRECTORY_SEPARATOR . 'sppd_qrcode.png';
if ($type === $model::PDF_TYPE_BARCODE && ($force || !file_exists($qrCodeFilename))) {
    $renderer = new ImageRenderer(
        new RendererStyle(400),
        new ImagickImageBackEnd()
    );
    $writer = new Writer($renderer);
    $writer->writeFile($model->linkPdfSppdTtd, $qrCodeFilename);
}

$suratTugas = $model->pelaksanaTugas->suratTugas;
?>
<html>

<body>
    <style>
        @page {
            margin: 20px 40px 30px 60px;
            padding: 0;
            size: A4;
            font-size: 14px;
        }

        body {
            font-family: TimesNewRoman, "Times New Roman", Times, Tahoma, sans-serif;
            margin: 3cm 0cm 0cm 0cm;
            text-align: justify;
            background-position: right bottom;
            background-repeat: no-repeat;
        }

        div.header,
        div.footer {
            overflow: hidden;
            padding: 0;
            position: fixed;
            width: 100%;
        }

        div.header .logo {
            background-repeat: no-repeat;
            height: 3cm;
            left: 0;
            top: 0;
        }

        div.footer {
            bottom: 0;
            height: 1.63cm;
            left: 0;
            background-position: right top;
            background-repeat: no-repeat;
        }
    </style>
    <div class="header">
        <?php echo $this->render('_kop', ['model' => $suratTugas]) ?>
    </div>
    <div class="footer">

    </div>
    <div style="margin-right: 0">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
            <tr>
                <td style="width: 50%"></td>
                <td style="width: 10%">Lembar ke</td>
                <td style="width: 40%">: </td>
            </tr>
            <tr>
                <td></td>
                <td>Nomor</td>
                <td>: <?php echo $model->nomor ?></td>
            </tr>
            <tr>
                <td style="text-align: center" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center" colspan="3">
                    <div style="font-size: 18px;font-weight: bold;">SURAT PERINTAH PERJALANAN DINAS</div>
                </td>
            </tr>
            <tr>
                <td style="text-align: center" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border: 2px solid">
                        <tr>
                            <td style="border-right:none">&nbsp;</td>
                            <td style="border-left:none;width: 50%;">Berdasarkan Surat Perintah Tugas</td>
                            <td style="width: 50%;">Nomor: <?php echo $suratTugas->nomor ?></td>
                        </tr>
                        <tr>
                            <td style="border-right:none">1.</td>
                            <td style="border-left:none;">Pejabat berwenang yang memberi perintah</td>
                            <td><?php echo $suratTugas->fix_jabatan ?></td>
                        </tr>
                        <tr>
                            <td style="border-right:none">2.</td>
                            <td style="border-left:none;">Nama/Nip Pegawai yang diperintah</td>
                            <td><?php echo $model->pelaksanaTugas->fix_nama ?> <br /><?php echo $model->pelaksanaTugas->fix_nip ? 'NIP. ' . $model->pelaksanaTugas->fix_nip : '-' ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none;border-right: none;">3.</td>
                            <td style="border-bottom: none;border-left: none;">a. Pangkat dan Golongan ruang</td>
                            <td style="border-bottom: none">a. <?php echo $model->pelaksanaTugas->fix_pangkat_golongan ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: none;border-bottom: none;border-right: none;"></td>
                            <td style="border-top: none;border-bottom: none;border-left: none;">b. Jabatan/Instansi</td>
                            <td style="border-top: none;border-bottom: none">b. <?php echo $model->pelaksanaTugas->fix_jabatan ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: none;border-right: none;"></td>
                            <td style="border-top: none;border-left: none;">c. Tingkat Biaya Perjalanan Dinas</td>
                            <td style="border-top: none;">c. <?php echo $model->fix_tingkat_sppd ?></td>
                        </tr>
                        <tr>
                            <td style="border-right:none">4.</td>
                            <td style="border-left:none;">Maksud Perjalanan Dinas</td>
                            <td><?php echo $suratTugas->maksud ?></td>
                        </tr>
                        <tr>
                            <td style="border-right:none">5.</td>
                            <td style="border-left:none;">Alat angkutan yang diperlukan</td>
                            <td><?php echo $model->alat_angkutan ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none;border-right: none;">6.</td>
                            <td style="border-bottom: none;border-left: none;">a. Tempat berangkat</td>
                            <td style="border-bottom: none">a. <?php echo $model->wilayahBerangkat->nama ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: none;border-right: none;"></td>
                            <td style="border-top: none;border-left: none;">b. Tempat tujuan</td>
                            <td style="border-top: none;">b. <?php echo $model->wilayahTujuan->nama ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none;border-right: none;">7.</td>
                            <td style="border-bottom: none;border-left: none;">a. Lamanya perjalanan dinas</td>
                            <td style="border-bottom: none">a. <?php echo $suratTugas->jumlah_hari ?> hari</td>
                        </tr>
                        <tr>
                            <td style="border-top: none;border-bottom: none;border-right: none;"></td>
                            <td style="border-top: none;border-bottom: none;border-left: none;">b. Tanggal berangkat</td>
                            <td style="border-top: none;border-bottom: none">b. <?php echo Yii::$app->formatter->asDate($model->tanggal_berangkat) ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: none;border-right: none;"></td>
                            <td style="border-top: none;border-left: none;">c. Tanggal harus kembali/tiba ditempat baru *)</td>
                            <td style="border-top: none;">c. <?php echo Yii::$app->formatter->asDate($model->tanggal_kembali) ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none;border-right: none;">8.</td>
                            <td style="border-bottom: none;border-left: none;">Pembebanan anggaran</td>
                            <td style="border-bottom: none"></td>
                        </tr>
                        <tr>
                            <td style="border-top: none;border-bottom: none;border-right: none;"></td>
                            <td style="border-top: none;border-bottom: none;border-left: none;">a. Instansi</td>
                            <td style="border-top: none;border-bottom: none">a. <?php echo $model->fix_anggaran_opd ?></td>
                        </tr>
                        <tr>
                            <td style="border-top: none;border-right: none;"></td>
                            <td style="border-top: none;border-left: none;">b. Mata Anggaran</td>
                            <td style="border-top: none;">b. <?php echo $model->anggaran->kode_rekening ?></td>
                        </tr>
                        <tr>
                            <td style="border-right:none">9.</td>
                            <td style="border-left:none;">Keterangan</td>
                            <td><?php echo $model->keterangan ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="height: 40px;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table style="width:100%">
                        <tr>
                            <td></td>
                            <td style="width: 8cm; text-align: center">
                                <?php echo $suratTugas->fix_opd_kedudukan ?>, <?php echo \common\components\helpers\DateFormat::id($model->tanggal); ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center">
                                <?php echo $suratTugas->fix_jabatan ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 2cm"></td>
                            <td>
                                <?php if ($type === $model::PDF_TYPE_BARCODE) : ?>
                                    <img src="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['/image/barcode-sppd', 'id' => $model->id]) ?>" width="100">
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center; font-weight: bold;text-decoration: underline">
                                <?php echo $suratTugas->fix_nama ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">
                                <?php echo $suratTugas->fix_pangkat ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">
                                <?php echo $suratTugas->fix_nip ? 'NIP. ' . $suratTugas->fix_nip : '' ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>