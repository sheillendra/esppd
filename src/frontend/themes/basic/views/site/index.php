<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Portal BPKAD Kab. Halmahera Timur';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php echo Html::img(Yii::getAlias('@web') . '/images/halmatimur-248x300.png', ['width' => 100]) ?>
        <h1>Selamat Datang!</h1>
        <p class="lead">Di Portal Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD) Kabupaten Halmahera Timur, Portal ini dimaksudkan sebagai sarana publikasi untuk memberikan Informasi dan gambaran BPKAD Kabupaten Halmahera Timur dalam melaksanakan Pengelolaan Keuangan dan Aset Daerah. Melalui keberadaan portal ini kiranya masyarakat dapat mengetahui seluruh informasi tentang Kebijakan Pemerintah Kabupaten Halmahera Timur didalam Pengelolaan sektor Anggaran Keuangan & Aset Daerah di wilayah Pemerintah Kabupaten Halmahera Timur.</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Visi</h2>
                <p>Terwujudnya Pengelolaan Keuangan dan Aset Daerah yang Profesional dan Bertanggung Jawab dalam Mendukung Penyelenggaraan Pemerintahan dan Pembangunan Daerah.</p>
                <p><?php echo Html::a('Profil Selengkapnya', ['/profile'], ['class' => 'btn btn-default']) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>Misi</h2>
                <p>Dalam rangka mewujudkan visi tersebut, maka misi yang akan dilaksanakan adalah :</p>
                <ol>
                    <li>Mewujudkan Kualitas Pengelolaan Keuangan dan Aset Daerah yang Efektif dan Efisien</li>
                    <li>Mewujudkan Optimalisasi Pengelolaan Pendapatan Daerah melalui Kebijakan Intensifikasi dan Ekstensifikasi</li>
                    <li>Mewujudkan Kualitas Sumberdaya (SDM) Aparatur Bidang Anggaran dan Perbendaharaan, Bidang Pendapatan, Bidang Akuntansi dan Bidang Aset Daerah sesuai Standar Pelayanan Minimal</li>
                </ol>
            </div>
            <div class="col-lg-4">
                <h2>Saran & Kritik</h2>

                <p>Kritik dan saran terhadap kekurangan dan kesalahan yang ada sangat kami harapkan, guna penyempurnaan Portal ini dimasa yang akan datang. Semoga Portal ini dapat memberikan manfaat bagi kita semua.</p>

                <p><?php echo Html::a('Beri masukan', ['/feedback'], ['class' => 'btn btn-default']) ?></p>
            </div>
        </div>

    </div>
</div>
