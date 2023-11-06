<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * This is the extended model of class for table "{{%pelaksana_tugas}}".
 * 
 * PENDING:
 *   1. jika status sudah menunggu disahkan, sudah tidak boleh create baru
 * 
 * @property SppdExt $sppd
 * @property PendudukExt $penduduk
 * @property PegawaiExt $pegawai
 * @property SuratTugasExt $suratTugas
 * @property string $namaPelaksana
 */
class PelaksanaTugasExt extends PelaksanaTugas
{

    const STATUS_BELUM_SPPD = 1;
    const STATUS_SUDAH_SPPD = 2;
    const STATUS_LABEL = [
        self::STATUS_BELUM_SPPD => 'Belum SPPD',
        self::STATUS_SUDAH_SPPD => 'Sudah SPPD',
    ];

    /**
     * 
     * @return type
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            //'bedezign\yii2\audit\AuditTrailBehavior',
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['status', 'default', 'value' => 1],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'surat_tugas_id' => 'Surat Tugas',
            'pegawai_id' => 'Pegawai',
            'createdBy.username' => 'Dibuat oleh',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSppd()
    {
        return $this->hasOne('\common\models\SppdExt', ['pelaksana_tugas_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenduduk()
    {
        return $this->hasOne(PendudukExt::class, ['id' => 'penduduk_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(PegawaiExt::class, ['id' => 'pegawai_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuratTugas()
    {
        return $this->hasOne(SuratTugasExt::class, ['id' => 'surat_tugas_id']);
    }

    public function tambah()
    {
        $result = ['success' => false, 'message' => ''];
        if ($this->suratTugas->status > SuratTugasExt::STATUS_SEDANG_PROSES) {
            $result['message'] = 'Pelaksana sudah tidak bisa tambah';
            return $result;
        }

        if ($this->pegawai_id && $this->penduduk_id) {
            $result['message'] = 'Pilih salah satu pegawai atau penduduk';
            return $result;
        }
        if ($this->pegawai && $this->pegawai->sppdActive) {
            $result['message'] = 'Masih ada SPPD yang aktif dari pelaksana ini';
            return $result;
        }

        if ($this->save()) {
            $result['message'] = 'Pelaksana sudah ditambahkan';
            $result['success'] = true;
        } else {
            $result['message'] = $this->getFirstErrors();
        }

        return $result;
    }

    /**
     * @uses SuratTugasExt->siapDisahkan()
     */
    public function siapDisahkan()
    {
        if ($this->pegawai) {
            $this->fix_nama = $this->pegawai->namaLengkap;
            $this->fix_nip = $this->pegawai->nip;
            if ($this->pegawai->pejabatStruktural) {
                $this->fix_jabatan = $this->pegawai->pejabatStruktural->jabatanStruktural->nama;
            } elseif ($this->pegawai->pejabatKeuangan) {
                $this->fix_jabatan = $this->pegawai->pejabatKeuangan->jabatanKeuangan->nama;
            } else {
                $this->fix_jabatan = '-';
            }
            $this->fix_pangkat_golongan = $this->pegawai->pangkatGolongan->pangkatLengkap;
        } else {
            $this->fix_nama = $this->penduduk->namaLengkap;
            $this->fix_nip = '-';
            if ($this->penduduk->pejabatDaerah) {
                $this->fix_jabatan = $this->penduduk->pejabatDaerah->jabatanDaerah->nama;
            } else {
                $this->fix_jabatan = '-';
            }
            $this->fix_pangkat_golongan = '-';
        }
        $this->save();
    }

    public function kembaliProses()
    {
        $this->fix_nama = null;
        $this->fix_nip = null;
        $this->fix_jabatan = null;
        $this->fix_pangkat_golongan = null;
        $this->save();
    }

    /**
     * {@inheritdoc}
     * @return PelaksanaTugasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PelaksanaTugasQueryExt(get_called_class());
    }
}
