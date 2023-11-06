<?php

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use common\components\helpers\Number;
use common\components\helpers\DateFormat;

/* @var $model \common\models\SuratTugasExt */

if ($model->tanggal_terbit === $model->tanggal_mulai) {
    $tanggalMulai = 'diterbitkannya Surat Tugas ini';
} else {
    $tanggalMulai = DateFormat::id($model->tanggal_mulai);
}

$qrCodeFilename = $path . DIRECTORY_SEPARATOR . 'qrcode.png';
if ($type === $model::PDF_TYPE_BARCODE && !file_exists($qrCodeFilename)) {
    $renderer = new ImageRenderer(
            new RendererStyle(400), new ImagickImageBackEnd()
    );
    $writer = new Writer($renderer);
    $writer->writeFile(
            $model->linkTtd
            , $qrCodeFilename);
}
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

            div.header, div.footer{
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
            <?php echo $this->render('_kop', ['model' => $model]) ?>
        </div>
        <div class="footer">

        </div>
        <div style="margin-right: 0">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                <tr>
                    <td style="text-align: center"><div style="font-size: 14px;font-weight: bold;text-decoration: underline">S U R A T&nbsp;&nbsp;&nbsp;T U G A S</div><div>Nomor: <?php echo $model->nomor ?></div></td>
                </tr>
                <tr><td style="height: 40px"></td></tr>
                <tr>
                    <td><?php echo $model->fix_jabatan ?> dengan ini menugaskan kepada: </td>
                </tr>
                <tr><td style="height: 18px"></td></tr>
                <tr>
                    <td>
                        <table border="1" cellpadding="2" cellspacing="0" style="width: 100%">
                            <tr style="background-color: darkgray">
                                <th>No</th>
                                <th style="width: 30%">Nama</th>
                                <th>NIP</th>
                                <th style="width: 30%">Jabatan</th>
                                <th>Pangkat/Gol./Ruang</th>
                            </tr>
                            <?php foreach ($model->pelaksanaTugas as $k => $petugas): ?>
                                <tr>
                                    <td><?php echo $k + 1 ?></td>
                                    <td><?php echo $petugas->fix_nama ?></td>
                                    <td><?php echo $petugas->fix_nip ?></td>
                                    <td><?php echo $petugas->fix_jabatan ?></td>
                                    <td><?php echo $petugas->fix_pangkat_golongan ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
                <tr><td style="height: 18px"></td></tr>
                <tr>
                    <td>Untuk <?php echo nl2br($model->maksud) ?></td>
                </tr>
                <tr><td style="height: 18px"></td></tr>
                <tr>
                    <td>Penugasan ini dilaksanakan selama <?php echo $model->jumlah_hari ?> (<?php echo trim(Number::indonesianWords($model->jumlah_hari)) ?>) hari kalender terhitung mulai tanggal diterbitkan surat tugas ini.</td>
                </tr>
                <tr><td style="height: 18px"></td></tr>
                <tr>
                    <td>Demikian untuk dilaksanakan dengan penuh tanggung jawab.</td>
                </tr>
                <tr><td style="height: 60px"></td></tr>
                <tr>
                    <td>
                        <table style="width:100%">
                            <tr>
                                <td></td>
                                <td style="width: 8cm; text-align: center">
                                    <?php echo $model->fix_opd_kedudukan ?>, <?php echo DateFormat::id($model->tanggal_terbit); ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center">
                                    <?php echo $model->fix_jabatan ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="height: 2cm"></td>
                                <td>
                                    <?php if ($type === $model::PDF_TYPE_BARCODE): ?>
                                        <img src="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['/image/barcode-surat-tugas', 'id' => $model->id]) ?>" width="100">
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center; font-weight: bold;text-decoration: underline">
                                    <?php echo $model->fix_nama ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center;">
                                    <?php echo $model->fix_pangkat ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center;">
                                    <?php echo $model->fix_nip ? 'NIP. ' . $model->fix_nip : '' ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>