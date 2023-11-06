<?php

namespace common\components\i18n;

use common\models\PelaksanaTugasExt;

class Formatter extends \yii\i18n\Formatter {

    public $activeFormat = [
        0 => 'Tidak Aktif',
        1 => 'Aktif',
    ];
    public $statusSuratFormat = [
        1 => 'Sedang diproses',
        2 => 'Menunggu disahkan',
        3 => 'Sudah Terbit',
    ];
    public $genderFormat = [
        0 => 'Tidak diketahui',
        1 => 'Laki-laki',
        2 => 'Perempuan',
    ];
    public $opdFormat;
    private $_pegawaiFormat;
    private $_jenisBiayaSppdFormat;

    public function asActive($value) {
        return $this->activeFormat[(int) $value];
    }

    public function asGender($value) {
        return $this->genderFormat[(int) $value];
    }

    public function asJabatanDaerah($value) {
        if ($value === null) {
            return '-';
        }
        return $this->getJabatanDaerah((int) $value);
    }

    private $_jabatanDaerah = [];

    public function getJabatanDaerah($value) {
        if (!isset($this->_jabatanDaerah[$value])) {
            $this->_jabatanDaerah[$value] = \common\models\JabatanDaerahExt::find()
                    ->select(['nama'])
                    ->where(['id' => $value])
                    ->scalar();
        }
        return $this->_jabatanDaerah[$value];
    }

    public function asJabatanStruktural($value) {
        if ($value === null) {
            return '-';
        }
        return $this->getJabatanStruktural((int) $value);
    }

    private $_jabatanStruktural = [];

    public function getJabatanStruktural($value) {
        if (!isset($this->_jabatanStruktural[$value])) {
            $this->_jabatanStruktural[$value] = \common\models\JabatanStrukturalExt::find()
                    ->select(['nama'])
                    ->where(['id' => $value])
                    ->scalar();
        }
        return $this->_jabatanStruktural[$value];
    }

    public function asJenisBiayaSppd($value) {
        if ($this->_jenisBiayaSppdFormat === null) {
            $this->_jenisBiayaSppdFormat = \common\models\JenisBiayaSppdExt::dataList();
        }
        return $this->_jenisBiayaSppdFormat[$value];
    }

    public function asKategoriWilayah($value) {
        return \common\models\WilayahExt::LABEL_KATEGORI[(int) $value];
    }
    
    public function asLevelWilayah($value) {
        return \common\models\WilayahExt::LABEL_LEVEL[(int) $value];
    }

    public function asOpd($value) {
        if (empty((int) $value)) {
            return null;
        }
        if ($this->opdFormat === null) {
            $this->opdFormat = \common\models\OpdExt::dataList();
        }

        if (isset($this->opdFormat[(int) $value])) {
            return $this->opdFormat[(int) $value];
        }
        return null;
    }

    public function asPegawai($value) {
        if ($value === null) {
            return '-';
        }
        return $this->getNamaPegawai((int) $value);
    }

    private $_namaPegawai = [];

    public function getNamaPegawai($value) {
        if (!isset($this->_namaPegawai[$value])) {
            $this->_namaPegawai[$value] = \common\models\PegawaiExt::find()
                    ->select(['COALESCE(gelar_depan || \' \', \'\') || nama_tanpa_gelar || COALESCE(\', \' || gelar_belakang, \'\')'])
                    ->where(['id' => $value])
                    ->scalar();
        }
        return $this->_namaPegawai[$value];
    }

    private $_pelaksanaTugas = [];

    public function asPelaksanaTugas($value) {
        if ($value === null) {
            return '-';
        }

        if (!isset($this->_pelaksanaTugas[$value])) {
            $pelaksanaTugas = PelaksanaTugasExt::findOne(['id' => $value]);
            $this->_pelaksanaTugas[$value] = $pelaksanaTugas->namaPelaksana;
        }
        return $this->_pelaksanaTugas[$value];
    }

    public function asPenduduk($value) {
        if ($value === null) {
            return '-';
        }
        return $this->getNamaPenduduk((int) $value);
    }

    private $_namaPenduduk = [];

    public function getNamaPenduduk($value) {
        if (!isset($this->_namaPenduduk[$value])) {
            $this->_namaPenduduk[$value] = \common\models\PendudukExt::find()
                    ->select(['COALESCE(gelar_depan || \' \', \'\') || nama_tanpa_gelar || COALESCE(\', \' || gelar_belakang, \'\')'])
                    ->where(['id' => $value])
                    ->scalar();
        }
        return $this->_namaPenduduk[$value];
    }

//    public function getPegawaiFormat() {
//        if ($this->_pegawaiFormat === null) {
//            $this->_pegawaiFormat = \common\models\PegawaiExt::dataList();
//        }
//        return $this->_pegawaiFormat;
//    }

    public function asStatusSurat($value) {
        return $this->statusSuratFormat[(int) $value];
    }

    public function asStatusSppd($value) {
        return \common\models\SppdExt::LABEL_STATUS[(int) $value];
    }

    public function asStatusUser($value) {
        return \common\models\UserExt::STATUS_LABEL[(int) $value];
    }

    private $_satuan;

    public function asSatuan($value) {
        if ($this->_satuan === null) {
            $this->_satuan = \common\models\SatuanExt::dataList();
        }
        return $this->_satuan[$value];
    }

    public function asStatusPelaksanaTugas($value) {
        return \common\models\PelaksanaTugasExt::STATUS_LABEL[(int) $value];
    }

    public function asStatusTahunAnggaran($value) {
        return \common\models\TahunAnggaranExt::STATUS_LABEL[(int) $value];
    }

    private $_tahunAnggaran;

    public function asTahunAnggaran($value) {
        if ($this->_tahunAnggaran === null) {
            $this->_tahunAnggaran = \common\models\TahunAnggaranExt::dataList();
        }
        return $this->_tahunAnggaran[$value];
    }

    public function asToview($value) {
        return $value;
    }

}
