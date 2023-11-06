<?php
/* @var $model \common\models\SppdExt */

$suratTugas = $model->pelaksanaTugas->suratTugas;
if ($suratTugas->pejabat_daerah_id) {
    $opd = $suratTugas->pejabatDaerah->jabatanDaerah->opd;
    $pejabatPemberiPerintah = $suratTugas->pejabatDaerah->penduduk->nama_tanpa_gelar;
    $jabatanPemberiPerintah = $suratTugas->pejabatDaerah->jabatanDaerah->nama;
    $pangkat = '';
    $nip = '';
} else {
    $opd = $suratTugas->pejabatStruktural->jabatanStruktural->opd;
    $pejabatPemberiPerintah = $suratTugas->pejabatStruktural->pegawai->nama_tanpa_gelar;
    $jabatanPemberiPerintah = $suratTugas->pejabatStruktural->jabatanStruktural->nama;
    $pangkat = $suratTugas->pejabatStruktural->pegawai->pangkatGolongan->pangkat . '/' .
            $suratTugas->pejabatStruktural->pegawai->pangkatGolongan->golongan . '/' .
            $suratTugas->pejabatStruktural->pegawai->pangkatGolongan->ruang;
    $nip = 'NIP. ' . $suratTugas->pejabatStruktural->pegawai->nip;
}

if ($model->pelaksanaTugas->pegawai_id) {
    $namaPelaksanaTugas = $model->pelaksanaTugas->pegawai->nama_tanpa_gelar;
    $nipPelaksanaTugas = $model->pelaksanaTugas->pegawai->nip;
    $pangkatPelaksanaTugas = $model->pelaksanaTugas->pegawai->pangkatGolongan->pangkat . '/' .
            $model->pelaksanaTugas->pegawai->pangkatGolongan->golongan . '/' .
            $model->pelaksanaTugas->pegawai->pangkatGolongan->ruang;
    if (isset($model->pelaksanaTugas->pegawai->pejabatStrukturals[0])) {
        $jabatanPelaksanaTugas = $model->pelaksanaTugas->pegawai
                ->pejabatStrukturals[0]->jabatanStruktural->nama_2;
    } else {
        $jabatanPelaksanaTugas = '-';
    }
    $jabatanPelaksanaTugas .= '/' .
            $model->pelaksanaTugas->pegawai->opd->singkatan;

    if ($model->pelaksanaTugas->pegawai->eselon) {
        $tingkatSppd = $model->pelaksanaTugas->pegawai->eselon->tingkat_sppd;
    } else {
        $tingkatSppd = $model->pelaksanaTugas->pegawai->pangkatGolongan->tingkat_sppd;
    }
}

if ($suratTugas->tanggal_terbit === $suratTugas->tanggal_mulai) {
    $tanggalMulai = 'diterbitkannya Surat Tugas ini';
} else {
    $tanggalMulai = \common\components\helpers\DateFormat::id($suratTugas->tanggal_mulai);
}
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
            <table border="1" cellpadding="5" cellspacing="0" style="border: 2px solid; width: 100%">
                <tr style="vertical-align: top">
                    <td style="border-right: none;width: 0.7cm;">I</td>
                    <td style="border-left: none;width: 8cm;">&nbsp;</td>
                    <td style="width: 8cm;">
                        <?php echo $this->render('visum-berangkat') ?>
                    </td>
                </tr>
                <tr style="vertical-align: top">
                    <td style="border-right: none;">II</td>
                    <td style="border-left: none;">
                        <?php echo $this->render('visum-tiba') ?>
                    </td>
                    <td>
                        <?php echo $this->render('visum-berangkat') ?>
                    </td>
                </tr>
                <tr style="vertical-align: top">
                    <td style="border-right: none;">III</td>
                    <td style="border-left: none;">
                        <?php echo $this->render('visum-tiba') ?>
                    </td>
                    <td>
                        <?php echo $this->render('visum-berangkat') ?>
                    </td>
                </tr>
                <tr style="vertical-align: top">
                    <td style="border-right: none;">IV</td>
                    <td style="border-left: none;">
                        <?php echo $this->render('visum-tiba') ?>
                    </td>
                    <td>
                        <?php echo $this->render('visum-berangkat') ?>
                    </td>
                </tr>
                <tr style="vertical-align: top">
                    <td style="border-right: none;">V</td>
                    <td style="border-left: none;">
                        <?php echo $this->render('visum-tiba') ?>
                    </td>
                    <td>
                        <?php echo $this->render('visum-berangkat') ?>
                    </td>
                </tr>
                <tr style="vertical-align: top">
                    <td style="border-right: none;">VI</td>
                    <td style="border-left: none;"></td>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                            <tr>
                                <td>Tiba kembali di</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Pada tanggal</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="height: 10px"></td>
                            </tr>
                            <tr>
                                <td colspan="3">Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="height: 10px"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center"><?php echo $jabatanPemberiPerintah ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="height: 50px"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center; font-weight: bold;text-decoration: underline">
                                    <?php echo $pejabatPemberiPerintah ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center"><?php echo $pangkat; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: center"><?php echo $nip; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="vertical-align: top">
                    <td style="border-right: none;">VII</td>
                    <td  style="border-left: none;" colspan="2">Catatan lain: </td>
                </tr>
                <tr style="vertical-align: top">
                    <td style="border-right: none;">VIII</td>
                    <td  style="border-left: none;" colspan="2"><strong>PERHATIAN:</strong><br>Pejabat yang berwenang menerbitkan SPPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat / tiba, serta Bendaharawan bertanggung jawab berdasarkan peraturan - peraturan keuangan Negara, apabila Negara menderita rugi akibat kesalahan, kelalaian dan kealpaannya.</td>
                </tr>
            </table>
        </div>
    </body>
</html>