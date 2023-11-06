<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * {@inheritdoc}
 * @property PejabatKeuanganExt[] $pejabatKeuangansIndexJabatan
 * @property PegawaiExt $penggunaAnggaran
 * @property PegawaiExt $pelaksanaTeknik
 * @property PegawaiExt $bendaharaPengeluaran
 * @property PegawaiExt $penatausahaanKeuangan
 */
class OpdExt extends Opd
{

    private $_penggunaAnggaran;
    private $_pelaksanaTeknik;
    private $_bendaharaPengeluaran;
    private $_penatausahaanKeuangan;

    /**
     * 
     * @return type
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            //'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['status', 'default', 'value' => 1]
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'induk_id' => 'OPD Induk',
            'baris_kop_1' => 'Alamat di Kop Surat',
            'baris_kop_2' => 'Email di Kop Surat',
            'created_at' => 'Dibuat pada',
            'createdBy.username' => 'Dibuat oleh',
            'updated_at' => 'Diubah pada',
            'updatedBy.username' => 'Diubah oleh'
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatKeuangansIndexJabatan()
    {
        return $this->hasMany(PejabatKeuanganExt::className(), ['opd_id' => 'id'])
            ->where(['status' => PejabatKeuanganExt::STATUS_ACTIVE])
            ->indexBy('jabatan_keuangan_id');
    }

    /**
     * @return \common\models\PegawaiExt
     */
    public function getPenggunaAnggaran()
    {
        if ($this->_penggunaAnggaran === null) {
            $this->_penggunaAnggaran = isset($this->pejabatKeuangansIndexJabatan[JabatanKeuanganExt::JABATAN_PENGGUNA_ANGGARAN]) ?
                $this->pejabatKeuangansIndexJabatan[JabatanKeuanganExt::JABATAN_PENGGUNA_ANGGARAN]->pegawai :
                new PegawaiExt();
        }
        return $this->_penggunaAnggaran;
    }

    /**
     * @return \common\models\PegawaiExt
     */
    public function getPelaksanaTeknik()
    {
        if ($this->_pelaksanaTeknik === null) {
            $this->_pelaksanaTeknik = isset($this->pejabatKeuangansIndexJabatan[JabatanKeuanganExt::JABATAN_PELAKSANA_TEKNIK]) ?
                $this->pejabatKeuangansIndexJabatan[JabatanKeuanganExt::JABATAN_PELAKSANA_TEKNIK]->pegawai :
                new PegawaiExt();
        }
        return $this->_pelaksanaTeknik;
    }

    /**
     * @return \common\models\PegawaiExt
     */
    public function getBendaharaPengeluaran()
    {
        if ($this->_bendaharaPengeluaran === null) {
            $this->_bendaharaPengeluaran = isset($this->pejabatKeuangansIndexJabatan[JabatanKeuanganExt::JABATAN_BENDAHARA_PENGELUARAN]) ?
                $this->pejabatKeuangansIndexJabatan[JabatanKeuanganExt::JABATAN_BENDAHARA_PENGELUARAN]->pegawai :
                new PegawaiExt();
        }
        return $this->_bendaharaPengeluaran;
    }

    /**
     * @return \common\models\PegawaiExt
     */
    public function getPenatausahaanKeuangan()
    {
        if ($this->_penatausahaanKeuangan === null) {
            $this->_penatausahaanKeuangan = isset($this->pejabatKeuangansIndexJabatan[JabatanKeuanganExt::JABATAN_PENATAUSAHAAN_KEUANGAN]) ?
                $this->pejabatKeuangansIndexJabatan[JabatanKeuanganExt::JABATAN_PENATAUSAHAAN_KEUANGAN]->pegawai :
                new PegawaiExt();
        }
        return $this->_penatausahaanKeuangan;
    }

    public static function dataList()
    {
        $query = static::find()
            ->select(['nama'])
            ->indexBy('id');
        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $query->andWhere(['id' => $opdAdmin]);
        }
        return $query->column();
    }

    public static function dataListOptions()
    {
        $query = static::find()
            ->select(['id as "value"', 'singkatan || \' \' || nama "data-tokens" ']);

        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $query->andWhere(['id' => $opdAdmin]);
        }

        return $query
            ->indexBy('value')
            ->asArray()->all();
    }
}
