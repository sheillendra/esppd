<?php

namespace common\models;

use Exception;
use Yii;
use yii\caching\TagDependency;
use yii\web\ServerErrorHttpException;

/**
 * @property PelaksanaTugasExt $pelaksanaTugas
 * @property AnggaranExt $anggaran
 * @property WilayahExt $wilayahTujuan
 * @property RincianBiayaSppdExt[] $rincianBiayaSppds
 * @property RincianBiayaSppdExt[] $rincianBiayaSppdsByKategori
 * @property int $totalBiaya
 */
class SppdExt extends Sppd
{

    /**
     * Status
     */
    const STATUS_SEDANG_PROSES = 1;
    const STATUS_HITUNG_BIAYA = 11;
    const STATUS_PENGESAHAN = 20;
    const STATUS_TERBIT = 30;
    const STATUS_DIBATALKAN = 35;
    const STATUS_HITUNG_RAMPUNG = 40;

    /**
     * Label
     */
    const LABEL_STATUS = [
        self::STATUS_SEDANG_PROSES => 'Sedang diproses',
        self::STATUS_HITUNG_BIAYA => 'Sedang hitung biaya',
        self::STATUS_PENGESAHAN => 'Menunggu disahkan',
        self::STATUS_TERBIT => 'Sudah terbit',
        self::STATUS_DIBATALKAN => 'Dibatalkan',
        self::STATUS_HITUNG_RAMPUNG => 'Hitung Rampung',
    ];

    /**
     * Scenario
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_UBAH_STATUS = 'ubahStatus';
    const SCENARIO_HITUNG_BIAYA = 'hitungbiaya';
    const SCENARIO_SIAP_DISAHKAN = 'siapdisahkan';
    const SCENARIO_UPLOAD_TTD = 'uploadttd';
    const SCENARIO_DITERBITKAN = 'diterbitkan';
    const SCENARIO_HITUNG_RAMPUNG = 'hitungrampung';

    /**
     * PDF type
     */
    const PDF_TYPE_BLANK = 'blank';
    const PDF_TYPE_BARCODE = 'barcode';
    const PDF_TYPE_TTD = 'ttd';

    /**
     * Document type
     */
    const DOC_SPPD = 'sppd';
    const DOC_VISUM = 'visum';
    const DOC_BIAYA = 'biaya';
    const DOC_KWITANSI = 'kwitansi';
    const DOC_RIIL = 'riil';
    const DOC_RAMPUNG = 'rampung';

    /**
     * 
     */
    const TINGKAT_SPPD = [
        'F' => 'F',
        'E' => 'E',
        'D' => 'D',
        'C' => 'C',
        'B' => 'B',
        'A' => 'Á',
        'Pejabat Daerah' => 'Pejabat Daerah',
        'Pejabat Negara' => 'Pejabat Negara',
    ];

    public $pdfFilenameSppdTtd;

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

    public function fields()
    {
        $fields = parent::fields();
        $fields['link_sppd_blank'] = function () {
            return $this->linkPdfSppdBlank;
        };
        $fields['link_sppd_barcode'] = function () {
            return $this->linkPdfSppdBarcode;
        };
        $fields['link_sppd_ttd'] = function () {
            return $this->linkPdfSppdTtd;
        };
        $fields['link_visum'] = function () {
            return $this->linkPdfVisum;
        };
        $fields['link_biaya'] = function () {
            return $this->linkPdfBiaya;
        };
        $fields['link_kwitansi'] = function () {
            return $this->linkPdfKwitansi;
        };
        $fields['link_riil'] = function () {
            return $this->linkPdfRiil;
        };
        $fields['link_rampung'] = function () {
            return $this->linkPdfRampung;
        };
        return $fields;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                [
                    'nomor',
                    'wilayah_berangkat', 'wilayah_tujuan', 'anggaran_id',
                    'alat_angkutan'
                ],
                'required',
                'on' => self::SCENARIO_UPDATE
            ],
            [['tanggal', 'tanggal_berangkat', 'tanggal_kembali'], 'date', 'format' => 'php:Y-m-d'],
            [
                'tanggal_berangkat', 'compare', 'compareAttribute' => 'tanggal_kembali', 'operator' => '<=',
                'message' => 'Tanggal berangkat harus lebih kecil dari tanggal kembali'
            ],
            [['pdfFilenameSppdTtd'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'application/pdf'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'tanggal' => 'Tanggal Terbit',
            'wilayah_berangkat' => 'Tempat berangkat',
            'wilayah_tujuan' => 'Tempat Tujuan',
            'wilayahBerangkat.nama' => 'Tempat berangkat',
            'wilayahTujuan.nama' => 'Tempat Tujuan',
            'pelaksana_tugas_id' => 'Pelaksana Tugas',
            'created_at' => 'Dibuat pada tanggal',
            'createdBy.username' => 'Oleh',
            'updated_at' => 'Diubah terakhir pada',
            'updatedBy.username' => 'Oleh',
            'pelaksanaTugas.suratTugas.nomor' => 'Surat Tugas',
            'anggaran.kode_rekening' => 'Mata Anggaran',
            'fix_pa_nama' => 'Pengguna Anggaran',
            'fix_teknik_nama' => 'Pelaksana Teknik Kegiatan',
            'fix_bendahara_nama' => 'Bendahara Pengeluaran',
            'fix_penatausahaan_nama' => 'Penatausahaan Keuangan',
        ]);
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CREATE => [
                'pelaksana_tugas_id', 'tanggal',
                'tanggal_berangkat', 'tanggal_kembali', 'status'
            ],
            self::SCENARIO_UPDATE => [
                'anggaran_id', 'nomor', 'anggaran_id',
                'tanggal', 'wilayah_berangkat', 'wilayah_tujuan',
                'tanggal_berangkat', 'tanggal_kembali', 'alat_angkutan',
                'keterangan', 'anggaran_id'
            ],
            self::SCENARIO_UBAH_STATUS => ['status',],
            self::SCENARIO_HITUNG_BIAYA => [
                'status', 'total_biaya',
                'fix_tingkat_sppd', 'fix_anggaran_opd',
                'fix_anggaran_opd_singkatan', 'fix_kategori_wilayah',
            ],
            self::SCENARIO_SIAP_DISAHKAN => [
                'status', 'total_biaya',
                'fix_pa_nama', 'fix_pa_nip', 'fix_bendahara_nama',
                'fix_bendahara_nip',
            ],
            self::SCENARIO_UPLOAD_TTD => [
                'pdf_filename_sppd_ttd',
                'pdf_url_sppd_ttd',
            ],
            self::SCENARIO_DITERBITKAN => ['status',],
            self::SCENARIO_HITUNG_RAMPUNG => [
                'tanggal_rampung', 'total_bukti',
                'status', 'keterangan', 'saldo_awal', 'saldo_akhir', 'fix_teknik_nama',
                'fix_teknik_nip', 'fix_penatausahaan_nama', 'fix_penatausahaan_nip',
            ]
        ]);
    }

    /**
     * 
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $this->pelaksanaTugas->status = PelaksanaTugasExt::STATUS_BELUM_SPPD;
        $this->pelaksanaTugas->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasOne(PelaksanaTugasExt::className(), ['id' => 'pelaksana_tugas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnggaran()
    {
        return $this->hasOne(AnggaranExt::className(), ['id' => 'anggaran_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRincianBiayaSppds()
    {
        return $this->hasMany(RincianBiayaSppdExt::className(), ['sppd_id' => 'id']);
    }

    /**
     * @return RincianBiayaSppdExt
     */
    public function getRincianBiayaSppdsByKategori($kategori)
    {
        return $this->hasMany(RincianBiayaSppdExt::className(), ['sppd_id' => 'id'])
            ->where(['kategori_biaya_id' => $kategori])
            ->orderBy('urutan, tanggal, id')
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRincianBiayaSppdPerKategori()
    {
        return $this->hasMany(RincianBiayaSppdExt::className(), ['sppd_id' => 'id'])
            ->select(['kategori_biaya_id', 'SUM(total) total'])
            ->indexBy('kategori_biaya_id')
            ->groupBy('kategori_biaya_id, total')
            ->asArray();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTotalBiaya()
    {
        return $this->hasMany(RincianBiayaSppdExt::className(), ['sppd_id' => 'id'])
            ->sum('total');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWilayahTujuan()
    {
        return $this->hasOne(WilayahExt::className(), ['kode' => 'wilayah_tujuan']);
    }

    public function generateSppd($ptid)
    {
        $result = ['success' => false, 'message' => ''];

        $pelaksanaTugas = PelaksanaTugasExt::findOne(['id' => $ptid]);
        if (!$pelaksanaTugas) {
            $result['message'] = 'Pelaksana tugas tidak ditemukan.';
            return $result;
        }

        if ($pelaksanaTugas->sppd) {
            $result['message'] = 'SPPD sudah ada.';
            return $result;
        }

        if ($pelaksanaTugas->fix_nama === null) {
            $result['message'] = 'Surat Tugas belum fix, silahkan ubah status surat tugas';
            return $result;
        }

        $this->pelaksana_tugas_id = $ptid;
        $this->tanggal = $pelaksanaTugas->suratTugas->tanggal_terbit;
        $this->tanggal_berangkat = $pelaksanaTugas->suratTugas->tanggal_mulai;
        $this->tanggal_kembali = date('Y-m-d', strtotime($pelaksanaTugas->suratTugas->tanggal_mulai
            . ' ' . ($pelaksanaTugas->suratTugas->jumlah_hari - 1) . ' day'));
        $this->status = self::STATUS_SEDANG_PROSES;

        $transaction = $this->getDb()->beginTransaction();
        try {
            if ($this->save()) {
                $pelaksanaTugas->status = $pelaksanaTugas::STATUS_SUDAH_SPPD;
                if (!$pelaksanaTugas->save()) {
                    $result['message'] = $pelaksanaTugas->getFirstErrors();
                    Yii::error($result['message']);
                } else {
                    $transaction->commit();
                    $result['success'] = true;
                    $result['message'] = 'Generate SPPD Sukses';
                    return $result;
                }
            } else {
                $result['message'] = $this->getFirstErrors();
                Yii::error($result['message']);
            }
        } catch (\Exception $ex) {
            $result['message'] = $ex->getMessage();
            Yii::error($result['message']);
        }
        $transaction->rollBack();
        return $result;
    }

    public function prepareHitungBiaya()
    {
        $queryBiaya = JenisBiayaSppdExt::find()
            ->alias('t0')
            ->select([
                't0.*',
                't1.*',
                't2.harian',
                't3.nama nama_jabatan_daerah',
                't4.nama nama_jabatan_struktural',
            ])
            ->rightJoin('{{%besaran_biaya_sppd}} t1', 't1.jenis_biaya_sppd_id=t0.id')
            ->leftJoin('{{%satuan}} t2', 't0.satuan_id=t2.id')
            ->leftJoin('{{%jabatan_daerah}} t3', 't1.jabatan_daerah_id=t3.id')
            ->leftJoin('{{%jabatan_struktural}} t4', 't1.jabatan_struktural_id=t4.id')
            ->leftJoin('{{%produk_hukum}} t5', 't1.produk_hukum_id=t5.id')
            ->where(['t0.status' => 1])
            ->andWhere(['t5.status' => 1])
            ->andWhere(['or', ['t1.kategori_wilayah' => $this->wilayahTujuan->kategori], ['t1.wilayah_id' => $this->wilayah_tujuan]]);

        $tingkatPelaksanaTugas = [];
        if ($this->pelaksanaTugas->pegawai) {

            if (isset($this->pelaksanaTugas->pegawai->pejabatStrukturals[0])) {
                $tingkatPelaksanaTugas[] = ['t1.jabatan_struktural_id' => $this->pelaksanaTugas->pegawai->pejabatStruktural->jabatan_struktural_id];
                $this->fix_tingkat_sppd = $this->pelaksanaTugas->pegawai->pejabatStruktural->jabatanStruktural->tingkat_sppd;
            }

            if ($this->pelaksanaTugas->pegawai->eselon_id) {
                $tingkatPelaksanaTugas[] = ['t1.eselon_id' => $this->pelaksanaTugas->pegawai->eselon_id];
                if (empty($this->fix_tingkat_sppd)) {
                    $this->fix_tingkat_sppd = $this->pelaksanaTugas->pegawai->eselon->tingkat_sppd;
                }
            }

            if ($this->pelaksanaTugas->pegawai->pangkat_golongan_id) {
                $tingkatPelaksanaTugas[] = ['t1.pangkat_golongan_id' => $this->pelaksanaTugas->pegawai->pangkat_golongan_id];
                if (empty($this->fix_tingkat_sppd)) {
                    $this->fix_tingkat_sppd = $this->pelaksanaTugas->pegawai->pangkatGolongan->tingkat_sppd;
                }
            }
        } elseif ($this->pelaksanaTugas->penduduk) {
            if ($this->pelaksanaTugas->penduduk->pejabatDaerah) {
                $tingkatPelaksanaTugas[] = ['t1.jabatan_daerah_id' => $this->pelaksanaTugas->penduduk->pejabatDaerah->jabatan_daerah_id];
                $this->fix_tingkat_sppd = $this->pelaksanaTugas->penduduk->pejabatDaerah->jabatanDaerah->tingkat_sppd;
            } else {
                $tingkatPelaksanaTugas[] = ['t1.pangkat_golongan_id' => PangkatGolonganExt::KODE_NON_PNS];
                $this->fix_tingkat_sppd = PangkatGolonganExt::find()
                    ->select('tingkat_sppd')
                    ->where(['kode' => PangkatGolonganExt::KODE_NON_PNS])
                    ->scalar();
            }
        }

        if ($tingkatPelaksanaTugas) {
            if (count($tingkatPelaksanaTugas) > 1) {
                $queryBiaya->andWhere(array_merge(['or'], $tingkatPelaksanaTugas));
            } else {
                $queryBiaya->andWhere($tingkatPelaksanaTugas[0]);
            }
        }

        // berlaku untuk semua

        // $queryBiaya->orWhere([
        //     'and', [
        //         't1.pangkat_golongan_id' => null,
        //         't1.eselon_id' => null,
        //         't1.jabatan_daerah_id' => null,
        //         't1.jabatan_struktural_id' => null,
        //        ['or', 't1.kategori_wilayah' => $this->wilayahTujuan->kategori, 't1.wilayah_id' => $this->wilayah_tujuan]
        //     ]
        // ]);

        $queryBiaya->orWhere(
            <<<SQL
                ("t1"."pangkat_golongan_id" IS NULL) AND
                ("t1"."eselon_id" IS NULL) AND
                ("t1"."jabatan_daerah_id" IS NULL) AND
                ("t1"."jabatan_struktural_id" IS NULL) AND 
                (("t1"."kategori_wilayah"={$this->wilayahTujuan->kategori}) OR ("t1"."wilayah_id"='{$this->wilayah_tujuan}'))
SQL
        );
        //echo $queryBiaya->createCommand()->rawSql;
        //exit;
        $biayas = $queryBiaya->asArray()->all();
        if ($biayas) {
            //cari nilai yang tertinggi dari jenis biaya yang sama yang diperoleh, buang yang tidak dipake dari $biayas
            $nilaiTertinggi = [];
            foreach ($biayas as $k => $v) {
                if (isset($nilaiTertinggi[$v['jenis_biaya_sppd_id']])) {
                    if ($nilaiTertinggi[$v['jenis_biaya_sppd_id']]['v'] > $v['jumlah']) {
                        unset($biayas[$k]);
                        continue;
                    } else {
                        unset($biayas[$nilaiTertinggi[$v['jenis_biaya_sppd_id']]['k']]);
                    }
                }
                $nilaiTertinggi[$v['jenis_biaya_sppd_id']] = ['k' => $k, 'v' => $v['jumlah']];
            }
        }
        return $biayas;
    }

    public function hitungBiaya()
    {
        $result = [
            'success' => true,
            'message' => 'Status SPPD berhasil diubah menjadi HITUNG BIAYA',
        ];

        $this->scenario = self::SCENARIO_UPDATE;
        if (!$this->validate()) {
            throw new ServerErrorHttpException(implode('', $this->getFirstErrors()));
            // $result['success'] = false;
            // $result['message'] = 'Pastikan sumber anggaran, nomor, tempat berangkat dan tempat tujuan dilengkapi';
            // return $result;
        }

        $this->scenario = self::SCENARIO_HITUNG_BIAYA;

        $transaction = $this->getDb()->beginTransaction();
        try {
            $this->simpanBiaya($this->prepareHitungBiaya());
            $this->status = self::STATUS_HITUNG_BIAYA;
            $this->fix_anggaran_opd = $this->anggaran->opd->nama;
            $this->fix_anggaran_opd_singkatan = $this->anggaran->opd->singkatan;
            $this->fix_kategori_wilayah = $this->wilayahTujuan->getKategoriLabel();
            if ($this->save()) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
                $result['success'] = false;
                $result['message'] = $this->getFirstErrors();
            }
        } catch (\Exception $ex) {
            $result['success'] = false;
            $result['message'] = $ex->getMessage();
            $transaction->rollBack();
        }


        return $result;
    }

    protected function simpanBiaya($biayas)
    {
        if ($biayas) {
            $satuan = SatuanExt::find()->indexBy('id')->all();
            foreach ($biayas as $biaya) {
                $item = new RincianBiayaSppdExt();
                $item->sppd_id = $this->id;
                $item->jenis_biaya_id = $biaya['jenis_biaya_sppd_id'];
                $item->kategori_biaya_id = $biaya['kategori_biaya_sppd_id'];
                $item->uraian = $biaya['nama'];

                if ($biaya['eselon_id']) {
                    $item->uraian .= ' Eselon ' . $biaya['eselon_id'];
                } elseif ($biaya['pangkat_golongan_id']) {
                    $item->uraian .= ' Golongan ' . $biaya['pangkat_golongan_id'];
                } elseif ($biaya['jabatan_daerah_id']) {
                    $item->uraian .= ' ' . $biaya['nama_jabatan_daerah'];
                } elseif ($biaya['jabatan_struktural_id']) {
                    $item->uraian .= ' ' . $biaya['nama_jabatan_struktural'];
                }

                $item->tanggal = $this->tanggal_berangkat;
                $item->harga = $biaya['jumlah'];
                $item->satuan_id = $biaya['satuan_id'];
                if ($satuan[$item->satuan_id]->harian) {
                    $item->volume = $this->pelaksanaTugas->suratTugas->jumlah_hari;
                } else {
                    $item->volume = 1;
                }

                $item->total = $item->volume * $item->harga;
                $item->save();
            }
        }
    }

    public function siapDisahkan()
    {
        $result = [
            'success' => true,
            'message' => 'Status SPPD berhasil diubah menjadi SIAP DISAHKAN'
        ];

        if ($this->status < self::STATUS_HITUNG_BIAYA) {
            $result['success'] = false;
            $result['message'] = 'Status SPPD harus sudah di HITUNG BIAYA';
            return $result;
        }

        $this->scenario = self::SCENARIO_SIAP_DISAHKAN;
        $this->total_biaya = RincianBiayaSppdExt::find()->where(['sppd_id' => $this->id])->sum('total');
        $this->status = self::STATUS_PENGESAHAN;

        $this->fix_pa_nama = $this->anggaran->opd->penggunaAnggaran->nama;
        $this->fix_pa_nip = $this->anggaran->opd->penggunaAnggaran->nip;

        $this->fix_bendahara_nama = $this->anggaran->opd->bendaharaPengeluaran->nama;
        $this->fix_bendahara_nip = $this->anggaran->opd->bendaharaPengeluaran->nip;

        if (!$this->save()) {
            Yii::error($this->getFirstErrors());
            $result['success'] = false;
            $result['message'] = 'Terjadi kesalahan system';
        }

        return $result;
    }

    public function prosesKembali()
    {
        $result = [
            'success' => false,
            'message' => ''
        ];
        $this->scenario = self::SCENARIO_HITUNG_BIAYA;
        if (!$this->validate()) {
            $result['message'] = implode(',', $this->getFirstErrors());
            return $result;
        }

        try {
            $this->total_biaya = 0;
            $this->status = $this::STATUS_SEDANG_PROSES;
            $this->fix_tingkat_sppd = null;
            $this->fix_anggaran_opd = null;
            if ($this->save()) {
                RincianBiayaSppdExt::deleteAll(['sppd_id' => $this->id]);
                $result['success'] = true;
                $result['message'] = 'Status kembali menjadi "SEDANG PROSES" dan biaya SPPD berhasil dihapus.';
            } else {
                $result['message'] = implode(',', $this->getFirstErrors());
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $result;
    }

    public function hitungBiayaKembali()
    {
        $result = [
            'success' => true,
            'message' => 'Status SPPD berhasil diubah menjadi HITUNG BIAYA Kembali',
        ];

        if ($this->status < $this::STATUS_HITUNG_RAMPUNG && $this->status > $this::STATUS_HITUNG_BIAYA) {
            $this->total_biaya = 0;
            $this->pdf_filename_biaya_blank = null;
            $this->pdf_filename_biaya_barcode = null;
            $this->pdf_filename_kwitansi_blank = null;
            $this->pdf_filename_kwitansi_barcode = null;
            $this->status = $this::STATUS_HITUNG_BIAYA;
            if (!$this->save()) {
                throw new ServerErrorHttpException(implode('', $this->getFirstErrors()));
            }
        } else {
            $result['success'] = false;
            $result['message'] = 'Status SPPD harus SIAP DISAHKAN dan sebelum HITUNG RAMPUNG';
        }
        return $result;
    }

    /**
     * 
     * @return array
     */
    public function uploadTtd()
    {
        $result = [
            'success' => true,
            'message' => 'Uplod Dokumen SPPD yang sudah ditandatangni berhasil.'
        ];
        $this->scenario = self::SCENARIO_UPLOAD_TTD;
        return $result;
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
        $result['message'] = 'Status SPPD berhasil diubah menjadi DITERBITKAN';
        return $result;
    }

    public function hitungRampung()
    {
        $result = ['success' => false, 'message' => ''];

        if ($this->status < $this::STATUS_TERBIT) {
            $result['message'] = 'SPPD harus diterbitkan';
            return $result;
        }

        if (!$this->buktiLengkap()) {
            $result['message'] = 'Pastikan semua bukti lengkap terupload dan dikonfirmasi';
            return $result;
        }

        $transaction = $this->getDb()->beginTransaction();
        try {
            $this->scenario = self::SCENARIO_HITUNG_RAMPUNG;
            $this->status = self::STATUS_HITUNG_RAMPUNG;
            $this->total_bukti = RincianBiayaSppdExt::totalBukti($this->id);
            $this->saldo_awal = $this->anggaran->saldo;
            $this->saldo_akhir = $this->saldo_awal - $this->total_bukti;
            $this->fix_teknik_nama = $this->anggaran->opd->pelaksanaTeknik->nama;
            $this->fix_teknik_nip = $this->anggaran->opd->pelaksanaTeknik->nip;
            $this->fix_penatausahaan_nama = $this->anggaran->opd->penatausahaanKeuangan->nama;
            $this->fix_penatausahaan_nip = $this->anggaran->opd->penatausahaanKeuangan->nip;
            if ($this->save()) {
                $this->anggaran->catatanSaldo(
                    -$this->total_bukti,
                    'Penggunaan SPPD No. ' . $this->nomor
                );
                $transaction->commit();
            } else {
                $transaction->rollBack();
                Yii::error($this->getFirstErrors());
                $result['message'] = 'Terjadi kesalahan system';
                return $result;
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            Yii::error($ex->getMessage());
            $result['message'] = 'Terjadi kesalahan system';
            return $result;
        }
        $result['success'] = true;
        $result['message'] = 'SPPD berhasil dirampungkan';
        return $result;
    }

    public function buktiLengkap()
    {
        $result = true;
        foreach ($this->rincianBiayaSppds as $rincian) {
            if ($rincian->riil) {
                continue;
            }
            if (!$rincian->pdf_bukti || !$rincian->total_bukti) {
                $result = false;
                break;
            }
        }
        return $result;
    }

    /**
     * 
     */
    public function batalRampung()
    {
        $result = ['success' => false, 'message' => ''];

        if ($this->status != $this::STATUS_HITUNG_RAMPUNG) {
            $result['message'] = 'Pembatalan Hitung Rampung tidak bisa dilakukan';
            return $result;
        }

        $transaction = $this->getDb()->beginTransaction();
        try {
            $this->scenario = self::SCENARIO_HITUNG_RAMPUNG;
            $this->status = self::STATUS_TERBIT;
            $totalBukti = $this->total_bukti;
            $this->total_bukti = null;
            $this->tanggal_rampung = null;
            $this->saldo_awal = null;
            $this->saldo_akhir = null;
            $this->fix_teknik_nama = null;
            $this->fix_teknik_nip = null;
            $this->fix_penatausahaan_nama = null;
            $this->fix_penatausahaan_nip = null;
            if ($this->save()) {
                $this->anggaran->catatanSaldo(
                    $totalBukti,
                    'Pengembalian SPPD No. ' . $this->nomor
                );
                $transaction->commit();
            } else {
                Yii::error($this->getFirstErrors());
                $result['message'] = 'Terjadi kesalahan system';
                return $result;
            }
        } catch (\Exception $ex) {
            Yii::error($ex->getMessage());
        }
        $result['success'] = true;
        $result['message'] = 'Hitung rampung SPPD berhasil dibatalkan';
        return $result;
    }

    public function pdfId($data)
    {
        return Yii::$app->security->hashData(
            implode('|', $data),
            Yii::$app->params['hashKeyPdfSppd']
        );
    }

    /**
     * 
     * @param int $id
     * @return Array
     */
    public static function pdfIdExtract($id)
    {
        return explode('|', Yii::$app->security->validateData(
            $id,
            Yii::$app->params['hashKeyPdfSppd']
        ));
    }

    /**
     * 
     * @param Array|null $data
     * @return String
     */
    public function sheetId($data)
    {
        return Yii::$app->security->hashData(
            implode('|', $data),
            Yii::$app->params['hashKeySheetRegister']
        );
    }

    /**
     * 
     * @param type $id
     * @return Array
     */
    public static function sheetIdExtract($id)
    {
        return explode('|', Yii::$app->security->validateData(
            $id,
            Yii::$app->params['hashKeySheetRegister']
        ));
    }

    public function getUploadPath($register = false)
    {
        $path0 = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'sppd';
        if ($register) {
            $path1 = $path0 . DIRECTORY_SEPARATOR . 'register';
        } else {
            $path1 = $path0 . DIRECTORY_SEPARATOR . $this->id;
        }
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
     * @param int $fromDate
     * @param int $toDate
     * @return int
     */
    public static function getTotalSppd($fromDate = null, $toDate = null, $kategoriWilayah = null)
    {
        $query = static::find()
            ->alias('t0')
            ->leftJoin('{{%anggaran}} t1', 't0.anggaran_id = t1.id')
            ->leftJoin('{{%tahun_anggaran}} t2', 't1.tahun_anggaran_id = t2.id')
            ->where(['t2.status_anggaran' => TahunAnggaranExt::STATUS_BERJALAN]);
        if (Yii::$app->user->identity->opdAdmin) {
            $query->andWhere(['t1.opd_id' => Yii::$app->user->identity->opdAdmin]);
        }

        if ($fromDate !== null) {
            $query->andWhere(['>=', 't0.created_at', $fromDate]);
        }

        if ($toDate !== null) {
            $query->andWhere(['<=', 't0.created_at', $toDate]);
        }

        if ($kategoriWilayah !== null) {
            $query->leftJoin('{{%wilayah}} t3', 't0.wilayah_tujuan=t3.kode')
                ->andWhere(['t3.kategori' => $kategoriWilayah]);
        }

        return $query->count();
    }

    public function getLinkPdfSppdBlank()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/sppd',
            'id' => $this->pdfId([
                'id' => $this->id,
                'doc' => $this::DOC_SPPD,
                'type' => $this::PDF_TYPE_BLANK,
            ]),
        ]);
    }

    public function getLinkPdfSppdBarcode()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/sppd',
            'id' => $this->pdfId([
                'id' => $this->id,
                'doc' => $this::DOC_SPPD,
                'type' => $this::PDF_TYPE_BARCODE,
            ]),
        ]);
    }

    public function getLinkPdfSppdTtd()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/sppd',
            'id' => $this->pdfId([
                'id' => $this->id,
                'doc' => $this::DOC_SPPD,
                'type' => $this::PDF_TYPE_TTD,
            ]),
        ]);
    }

    public function getLinkPdfBiaya()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/sppd',
            'id' => $this->pdfId([
                'id' => $this->id,
                'doc' => $this::DOC_BIAYA,
                'type' => $this::PDF_TYPE_BLANK,
            ]),
        ]);
    }

    public function getLinkPdfVisum()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/sppd',
            'id' => $this->pdfId([
                'id' => $this->id,
                'doc' => $this::DOC_VISUM,
                'type' => $this::PDF_TYPE_BLANK,
            ]),
        ]);
    }

    public function getLinkPdfKwitansi()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/sppd',
            'id' => $this->pdfId([
                'id' => $this->id,
                'doc' => $this::DOC_KWITANSI,
                'type' => $this::PDF_TYPE_BLANK,
            ]),
        ]);
    }

    public function getLinkPdfRiil()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/sppd',
            'id' => $this->pdfId([
                'id' => $this->id,
                'doc' => $this::DOC_RIIL,
                'type' => $this::PDF_TYPE_BLANK,
            ]),
        ]);
    }

    public function getLinkPdfRampung()
    {
        return Yii::$app->urlManagerFrontend->createAbsoluteUrl([
            '/pdf/sppd',
            'id' => $this->pdfId([
                'id' => $this->id,
                'doc' => $this::DOC_RAMPUNG,
                'type' => $this::PDF_TYPE_BLANK,
            ]),
        ]);
    }
}
