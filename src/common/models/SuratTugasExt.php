<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\caching\TagDependency;

/**
 * @property PelaksanaTugasExt[] $pelaksanaTugas
 * @property PejabatDaerahExt $pejabatDaerah
 * @property PejabatStrukturalExt $pejabatStruktural
 * 
 */
class SuratTugasExt extends SuratTugas
{

    /**
     * Scenario
     */
    const SCENARIO_UBAH_STATUS = 'ubahstatus';
    const SCENARIO_UBAH_PENGESAHAN = 'pengesahan';
    const SCENARIO_UPLOAD_TTD = 'uploadttd';
    const SCENARIO_DITERBITKAN = 'terbitkan';

    /**
     * PDF Type
     */
    const PDF_TYPE_BLANK = 'blank';
    const PDF_TYPE_BARCODE = 'barcode';
    const PDF_TYPE_TTD = 'ttd';

    /**
     * Status
     */
    const STATUS_SEDANG_PROSES = 1;
    const STATUS_PENGESAHAN = 2;
    const STATUS_TERBIT = 3;
    const LABEL_STATUS = [
        self::STATUS_SEDANG_PROSES => 'Sedang diproses',
        self::STATUS_PENGESAHAN => 'Menunggu disahkan',
        self::STATUS_TERBIT => 'Sudah terbit',
    ];

    /**
     * Input for pejabat
     * 
     * @var integer 
     */
    public $perintahDari;
    public $pdfTtdFile;

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
            ['status', 'default', 'value' => self::STATUS_SEDANG_PROSES],
            [['perintahDari', 'pdfTtdFile'], 'safe'],
            [['pdfTtdFile'], 'file', 'mimeTypes' => ['application/pdf'], 'on' => self::SCENARIO_UPLOAD_TTD, 'extensions' => ['pdf']],
            ['pdf_url_ttd', 'url'],
        ]);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['link_blank'] = function () {
            return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
                '/pdf/surat-tugas',
                'id' => $this->pdfId([
                    'id' => $this->id,
                    'fn' => $this->pdf_filename_blank,
                    'type' => $this::PDF_TYPE_BLANK,
                ])
            ]);
        };

        $fields['link_barcode'] = function () {
            return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
                '/pdf/surat-tugas',
                'id' => $this->pdfId([
                    'id' => $this->id,
                    'fn' => $this->pdf_filename_barcode,
                    'type' => $this::PDF_TYPE_BARCODE,
                ])
            ]);
        };

        $fields['link_ttd'] = function () {
            return $this->getLinkTtd();
        };
        return $fields;
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_UBAH_STATUS => ['status',],
            self::SCENARIO_DITERBITKAN => ['status'],
            self::SCENARIO_UPLOAD_TTD => ['pdf_filename_ttd', 'pdf_url_ttd', 'pdfTtdFile'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'opd_id' => 'OPD',
            'opd.nama' => 'OPD',
            'pejabatDaerah.jabatanDaerah.nama' => 'Perintah Dari',
            'pejabatStruktural.jabatanStruktural.nama' => 'Perintah Dari',
            'wilayahBerangkat.nama' => 'Tempat Berangkat',
            'wilayahTujuan.nama' => 'Tempat Tujuan',
            'çreated_at' => 'Dibuat pada',
            'createdBy.username' => 'Dibuat Oleh',
            'updated_at' => 'Diupdate pada',
            'updatedBy.username' => 'Diupdate Oleh',
            'pdfTtdFile' => 'File PDF yang sudah ditandatangani',
            'pdf_url_ttd' => 'Alamat URL File PDF yang sudah ditandatangani',
        ]);
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasMany(PelaksanaTugasExt::className(), ['surat_tugas_id' => 'id'])
            ->orderBy('id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatDaerah()
    {
        return $this->hasOne(PejabatDaerahExt::class, ['id' => 'pejabat_daerah_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatStruktural()
    {
        return $this->hasOne(PejabatStrukturalExt::class, ['id' => 'pejabat_struktural_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuratTugas()
    {
        return $this->hasOne(SuratTugasExt::className(), ['id' => 'surat_tugas_id']);
    }

    public function validateEither($attribute, $params)
    {
        //if (empty($this->$attribute) && empty($this->$params['other'])) {
        $this->addError($attribute, 'File PDF atau URL salah satunya harus diisi');
        //}
    }

    // public static function dataList()
    // {
    //     return static::find()
    //         ->select(['nomor'])
    //         ->where(['status' => self::STATUS_SEDANG_PROSES])
    //         ->indexBy('id')
    //         ->column();
    // }

    public function siapDisahkan()
    {
        $result = [
            'success' => false,
            'message' => '',
        ];
        if ($this->pelaksanaTugas) {
            $this->changeStatusToPengesahan();
            if ($this->save()) {
                try {
                    foreach ($this->pelaksanaTugas as $pelaksanaTugas) {
                        $pelaksanaTugas->siapDisahkan();
                    }
                    $result['success'] = true;
                    $result['message'] = 'Status Surat Tugas menjadi PENGESAHAN';
                } catch (\Exception $e) {
                    $result['message'] = $e->getMessage();
                }
            } else {
                $result['message'] = $this->getFirstErrors();
            }
        } else {
            $result['message'] = 'Pelaksana tugas tidak boleh kosong';
        }
        return $result;
    }

    protected function changeStatusToPengesahan()
    {
        $this->status = $this::STATUS_PENGESAHAN;
        if ($this->pejabat_daerah_id) {
            if ($this->pejabatDaerah->jabatanDaerah->opd->induk) {
                $opd = $this->pejabatDaerah->jabatanDaerah->opd->induk;
            } else {
                $opd = $this->pejabatDaerah->jabatanDaerah->opd;
            }
            $this->fix_opd_nama = $opd->nama;
            if ($this->pejabatDaerah->jabatan_daerah_id === Yii::$app->params['kepalaDaerahJabatanId']) {
                $this->fix_opd_kop_1 = Yii::$app->params['namaKepalaPemerintahan1'];
                $this->fix_opd_kop_2 = Yii::$app->params['namaKepalaPemerintahan2'];
            } else {
                $this->fix_opd_kop_1 = $opd->baris_kop_1;
                $this->fix_opd_kop_2 = $opd->baris_kop_2;
            }
            $this->fix_opd_kedudukan = $opd->text_kedudukan;
            $this->fix_nama = $this->pejabatDaerah->penduduk->namaLengkap;
            $this->fix_jabatan = $this->pejabatDaerah->jabatanDaerah->nama;
        } else {
            if ($this->pejabatStruktural->jabatanStruktural->opd->induk) {
                $opd = $this->pejabatStruktural->jabatanStruktural->opd->induk;
            } else {
                $opd = $this->pejabatStruktural->jabatanStruktural->opd;
            }
            $this->fix_opd_nama = $opd->nama;
            $this->fix_opd_kop_1 = $opd->baris_kop_1;
            $this->fix_opd_kop_2 = $opd->baris_kop_2;
            $this->fix_opd_kedudukan = $opd->text_kedudukan;
            $this->fix_nama = $this->pejabatStruktural->pegawai->namaLengkap;
            $this->fix_jabatan = $this->pejabatStruktural->jabatanStruktural->nama;
            $this->fix_pangkat = $this->pejabatStruktural->pegawai->pangkatGolongan->pangkatLengkap;
            $this->fix_nip = $this->pejabatStruktural->pegawai->nip;
        }
    }

    public function prosesKembali()
    {
        $result = [
            'success' => false,
            'message' => '',
        ];
        if ($this->canOlahKembali()) {
            $this->changeStatusToProccess();
            if ($this->save()) {
                try {
                    foreach ($this->pelaksanaTugas as $pelaksanaTugas) {
                        $pelaksanaTugas->kembaliProses();
                    }
                    $result['success'] = true;
                    $result['message'] = 'Status Surat Tugas menjadi PROSES kembali';
                } catch (\Exception $e) {
                    $result['message'] = $e->getMessage();
                }
            } else {
                $result['message'] = $this->getFirstErrors();
            }
        } else {
            $result['message'] = 'Surat tugas ini sudah tidak bisa di olah kembali';
        }
        return $result;
    }

    public function canOlahKembali()
    {
        $result = true;
        foreach ($this->pelaksanaTugas as $pelaksanaTugas) {
            // //jika ada pelaksana tugas yang belum ada sppd
            // if ($pelaksanaTugas->status === PelaksanaTugasExt::STATUS_BELUM_SPPD) {
            //     $result = true;
            //     break;
            // }

            // //jika ada SPPD pelaksana tugas yang dibatalkan atau belum rampung
            // if ($pelaksanaTugas->sppd->status <= SppdExt::STATUS_DIBATALKAN) {
            //     $result = true;
            //     break;
            // }

            //tidak bisa olah kemabali jika sudah ada sppd
            if ($pelaksanaTugas->sppd) {
                $result = false;
            }
        }
        return $result;
    }

    protected function changeStatusToProccess()
    {
        $this->status = $this::STATUS_SEDANG_PROSES;
        $this->fix_opd_nama = null;
        $this->fix_opd_kop_1 = null;
        $this->fix_opd_kop_2 = null;
        $this->fix_opd_kedudukan = null;
        $this->fix_nama = null;
        $this->fix_jabatan = null;
        $this->fix_pangkat = null;
        $this->fix_nip = null;
        $this->pdf_filename_blank = null;
        $this->pdf_filename_barcode = null;
        $this->pdf_filename_ttd = null;
        $this->pdf_url_blank = null;
        $this->pdf_url_barcode = null;
        $this->pdf_url_ttd = null;
    }

    /**
     * 
     * @return array
     */
    public function terbitkan()
    {
        $result = ['success' => false, 'message' => ''];

        if ($this->status < self::STATUS_PENGESAHAN) {
            $result['message'] = 'SPPD harus disahkan terlebih dahulu';
            return $result;
        }

        $this->scenario = self::SCENARIO_DITERBITKAN;
        $this->status = self::STATUS_TERBIT;
        if (!$this->save()) {
            Yii::error($this->getFirstErrors());
            $result['message'] = 'Terjadi kesalahan system';
            return $result;
        }
        $result['success'] = true;
        $result['message'] = 'Status Surat Tugas berhasil diubah menjadi DITERBITKAN';
        return $result;
    }

    public function pdfId($data)
    {
        return Yii::$app->security->hashData(implode('|', $data), Yii::$app->params['hash_key_pdf_st']);
    }

    /**
     * 
     * @param type $id
     * @return Array
     */
    public static function pdfIdExtract($id)
    {
        return explode('|', Yii::$app->security->validateData(
            $id,
            Yii::$app->params['hash_key_pdf_st']
        ));
    }

    public function getUploadPath()
    {
        $path0 = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'surat-tugas';
        $path1 = $path0 . DIRECTORY_SEPARATOR . $this->id;
        if (!is_dir($path0)) {
            mkdir($path0);
        }

        if (!is_dir($path1)) {
            mkdir($path1);
        }

        return $path1;
    }

    /**
     * 
     * @return array
     */
    public function uploadTtd()
    {
        $result = ['success' => false, 'message' => ''];
        $this->pdfTtdFile = UploadedFile::getInstance($this, 'pdfTtdFile');
        if (!$this->validate()) {
            $result['message'] = $this->getFirstErrors();
            return $result;
        }
        $this->pdf_filename_ttd = str_replace('.', '_', microtime(true)) . '.' . $this->pdfTtdFile->extension;
        $this->pdfTtdFile->saveAs($this->getUploadPath() . DIRECTORY_SEPARATOR . $this->pdf_filename_ttd, false);
        if ($this->save() === false) {
            $result['message'] = $this->getFirstErrors();
            return $result;
        }
        $result['success'] = true;
        $result['message'] = 'Uplod Surat Tugas yang sudah ditandatangni berhasil.';
        return $result;
    }

    public function getLinkTtd()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/surat-tugas',
            'id' => $this->pdfId([
                'id' => $this->id,
                'fn' => $this->pdf_filename_ttd,
                'type' => $this::PDF_TYPE_TTD,
            ])
        ]);
    }
}
