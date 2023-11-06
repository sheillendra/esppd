<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sppd}}".
 *
 * @property int $id
 * @property string|null $kode_anggaran
 * @property int|null $produk_hukum_id
 * @property int $pelaksana_tugas_id
 * @property int|null $bendahara_pengeluaran_id BendaharaPengeluaranSPPD
 * @property int|null $pelaksana_teknik_kegiatan_id PelaksanaTeknikKegiatanSppd
 * @property string|null $nomor
 * @property string|null $tanggal
 * @property string|null $wilayah_berangkat
 * @property string|null $wilayah_tujuan
 * @property string|null $tanggal_berangkat
 * @property string|null $tanggal_kembali
 * @property string|null $tanggal_rampung
 * @property string|null $alat_angkutan
 * @property float|null $total_biaya
 * @property float|null $saldo_awal
 * @property float|null $saldo_akhir
 * @property int $status
 * @property string|null $keterangan
 * @property string|null $fix_tingkat_sppd
 * @property string|null $fix_anggaran_opd
 * @property string|null $fix_anggaran_opd_singkatan
 * @property string|null $fix_pa_nama Pengguna Anggaran
 * @property string|null $fix_pa_nip
 * @property string|null $fix_bendahara_nama Bendahara Pengeluaran
 * @property string|null $fix_bendahara_nip
 * @property string|null $fix_teknik_nama Pejabat Pelaksanaan Teknik Kegiatan
 * @property string|null $fix_teknik_nip
 * @property string|null $fix_penatausahaan_nama Pejabat Penatausahaan Keuangan SKPD
 * @property string|null $fix_penatausahaan_nip
 * @property string|null $fix_kategori_wilayah
 * @property string|null $pdf_filename_sppd_blank
 * @property string|null $pdf_filename_sppd_barcode
 * @property string|null $pdf_filename_sppd_ttd
 * @property string|null $pdf_filename_visum_blank
 * @property string|null $pdf_filename_visum_barcode
 * @property string|null $pdf_filename_visum_ttd
 * @property string|null $pdf_filename_biaya_blank
 * @property string|null $pdf_filename_biaya_barcode
 * @property string|null $pdf_filename_biaya_ttd
 * @property string|null $pdf_filename_kwitansi_blank
 * @property string|null $pdf_filename_kwitansi_barcode
 * @property string|null $pdf_filename_kwitansi_ttd
 * @property string|null $pdf_filename_riil_blank
 * @property string|null $pdf_filename_riil_barcode
 * @property string|null $pdf_filename_rill_ttd
 * @property string|null $pdf_filename_rampung_blank
 * @property string|null $pdf_filename_rampung_barcode
 * @property string|null $pdf_filename_rampung_ttd
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property float|null $total_bukti
 * @property string|null $pdf_url_sppd_ttd
 *
 * @property RincianBiayaSppd[] $rincianBiayaSppds
 * @property Anggaran $kodeAnggaran
 * @property PejabatKeuangan $bendaharaPengeluaran
 * @property PejabatKeuangan $pelaksanaTeknikKegiatan
 * @property PelaksanaTugas $pelaksanaTugas
 * @property ProdukHukum $produkHukum
 * @property User $createdBy
 * @property User $updatedBy
 * @property Wilayah $wilayahBerangkat
 * @property Wilayah $wilayahTujuan
 */
class Sppd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sppd}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produk_hukum_id', 'pelaksana_tugas_id', 'bendahara_pengeluaran_id', 'pelaksana_teknik_kegiatan_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['produk_hukum_id', 'pelaksana_tugas_id', 'bendahara_pengeluaran_id', 'pelaksana_teknik_kegiatan_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['pelaksana_tugas_id'], 'required'],
            [['tanggal', 'tanggal_berangkat', 'tanggal_kembali', 'tanggal_rampung'], 'safe'],
            [['total_biaya', 'saldo_awal', 'saldo_akhir', 'total_bukti'], 'number'],
            [['keterangan'], 'string'],
            [['kode_anggaran'], 'string', 'max' => 15],
            [['nomor'], 'string', 'max' => 60],
            [['wilayah_berangkat', 'wilayah_tujuan'], 'string', 'max' => 12],
            [['alat_angkutan', 'fix_anggaran_opd', 'fix_anggaran_opd_singkatan', 'fix_pa_nama', 'fix_pa_nip', 'fix_bendahara_nama', 'fix_bendahara_nip', 'fix_teknik_nama', 'fix_teknik_nip', 'fix_penatausahaan_nama', 'fix_penatausahaan_nip', 'fix_kategori_wilayah', 'pdf_url_sppd_ttd'], 'string', 'max' => 255],
            [['fix_tingkat_sppd', 'pdf_filename_sppd_blank', 'pdf_filename_sppd_barcode', 'pdf_filename_sppd_ttd', 'pdf_filename_visum_blank', 'pdf_filename_visum_barcode', 'pdf_filename_visum_ttd', 'pdf_filename_biaya_blank', 'pdf_filename_biaya_barcode', 'pdf_filename_biaya_ttd', 'pdf_filename_kwitansi_blank', 'pdf_filename_kwitansi_barcode', 'pdf_filename_kwitansi_ttd', 'pdf_filename_riil_blank', 'pdf_filename_riil_barcode', 'pdf_filename_rill_ttd', 'pdf_filename_rampung_blank', 'pdf_filename_rampung_barcode', 'pdf_filename_rampung_ttd'], 'string', 'max' => 40],
            [['kode_anggaran', 'produk_hukum_id'], 'exist', 'skipOnError' => true, 'targetClass' => Anggaran::className(), 'targetAttribute' => ['kode_anggaran' => 'kode', 'produk_hukum_id' => 'produk_hukum_id']],
            [['bendahara_pengeluaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => PejabatKeuangan::className(), 'targetAttribute' => ['bendahara_pengeluaran_id' => 'id']],
            [['pelaksana_teknik_kegiatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => PejabatKeuangan::className(), 'targetAttribute' => ['pelaksana_teknik_kegiatan_id' => 'id']],
            [['pelaksana_tugas_id'], 'exist', 'skipOnError' => true, 'targetClass' => PelaksanaTugas::className(), 'targetAttribute' => ['pelaksana_tugas_id' => 'id']],
            [['produk_hukum_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProdukHukum::className(), 'targetAttribute' => ['produk_hukum_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['wilayah_berangkat'], 'exist', 'skipOnError' => true, 'targetClass' => Wilayah::className(), 'targetAttribute' => ['wilayah_berangkat' => 'kode']],
            [['wilayah_tujuan'], 'exist', 'skipOnError' => true, 'targetClass' => Wilayah::className(), 'targetAttribute' => ['wilayah_tujuan' => 'kode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_anggaran' => 'Kode Anggaran',
            'produk_hukum_id' => 'Produk Hukum ID',
            'pelaksana_tugas_id' => 'Pelaksana Tugas ID',
            'bendahara_pengeluaran_id' => 'Bendahara Pengeluaran ID',
            'pelaksana_teknik_kegiatan_id' => 'Pelaksana Teknik Kegiatan ID',
            'nomor' => 'Nomor',
            'tanggal' => 'Tanggal',
            'wilayah_berangkat' => 'Wilayah Berangkat',
            'wilayah_tujuan' => 'Wilayah Tujuan',
            'tanggal_berangkat' => 'Tanggal Berangkat',
            'tanggal_kembali' => 'Tanggal Kembali',
            'tanggal_rampung' => 'Tanggal Rampung',
            'alat_angkutan' => 'Alat Angkutan',
            'total_biaya' => 'Total Biaya',
            'saldo_awal' => 'Saldo Awal',
            'saldo_akhir' => 'Saldo Akhir',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
            'fix_tingkat_sppd' => 'Fix Tingkat Sppd',
            'fix_anggaran_opd' => 'Fix Anggaran Opd',
            'fix_anggaran_opd_singkatan' => 'Fix Anggaran Opd Singkatan',
            'fix_pa_nama' => 'Fix Pa Nama',
            'fix_pa_nip' => 'Fix Pa Nip',
            'fix_bendahara_nama' => 'Fix Bendahara Nama',
            'fix_bendahara_nip' => 'Fix Bendahara Nip',
            'fix_teknik_nama' => 'Fix Teknik Nama',
            'fix_teknik_nip' => 'Fix Teknik Nip',
            'fix_penatausahaan_nama' => 'Fix Penatausahaan Nama',
            'fix_penatausahaan_nip' => 'Fix Penatausahaan Nip',
            'fix_kategori_wilayah' => 'Fix Kategori Wilayah',
            'pdf_filename_sppd_blank' => 'Pdf Filename Sppd Blank',
            'pdf_filename_sppd_barcode' => 'Pdf Filename Sppd Barcode',
            'pdf_filename_sppd_ttd' => 'Pdf Filename Sppd Ttd',
            'pdf_filename_visum_blank' => 'Pdf Filename Visum Blank',
            'pdf_filename_visum_barcode' => 'Pdf Filename Visum Barcode',
            'pdf_filename_visum_ttd' => 'Pdf Filename Visum Ttd',
            'pdf_filename_biaya_blank' => 'Pdf Filename Biaya Blank',
            'pdf_filename_biaya_barcode' => 'Pdf Filename Biaya Barcode',
            'pdf_filename_biaya_ttd' => 'Pdf Filename Biaya Ttd',
            'pdf_filename_kwitansi_blank' => 'Pdf Filename Kwitansi Blank',
            'pdf_filename_kwitansi_barcode' => 'Pdf Filename Kwitansi Barcode',
            'pdf_filename_kwitansi_ttd' => 'Pdf Filename Kwitansi Ttd',
            'pdf_filename_riil_blank' => 'Pdf Filename Riil Blank',
            'pdf_filename_riil_barcode' => 'Pdf Filename Riil Barcode',
            'pdf_filename_rill_ttd' => 'Pdf Filename Rill Ttd',
            'pdf_filename_rampung_blank' => 'Pdf Filename Rampung Blank',
            'pdf_filename_rampung_barcode' => 'Pdf Filename Rampung Barcode',
            'pdf_filename_rampung_ttd' => 'Pdf Filename Rampung Ttd',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'total_bukti' => 'Total Bukti',
            'pdf_url_sppd_ttd' => 'Pdf Url Sppd Ttd',
        ];
    }

    /**
     * Gets query for [[RincianBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|RincianBiayaSppdQuery
     */
    public function getRincianBiayaSppds()
    {
        return $this->hasMany(RincianBiayaSppd::className(), ['sppd_id' => 'id']);
    }

    /**
     * Gets query for [[KodeAnggaran]].
     *
     * @return \yii\db\ActiveQuery|AnggaranQuery
     */
    public function getKodeAnggaran()
    {
        return $this->hasOne(Anggaran::className(), ['kode' => 'kode_anggaran', 'produk_hukum_id' => 'produk_hukum_id']);
    }

    /**
     * Gets query for [[BendaharaPengeluaran]].
     *
     * @return \yii\db\ActiveQuery|PejabatKeuanganQuery
     */
    public function getBendaharaPengeluaran()
    {
        return $this->hasOne(PejabatKeuangan::className(), ['id' => 'bendahara_pengeluaran_id']);
    }

    /**
     * Gets query for [[PelaksanaTeknikKegiatan]].
     *
     * @return \yii\db\ActiveQuery|PejabatKeuanganQuery
     */
    public function getPelaksanaTeknikKegiatan()
    {
        return $this->hasOne(PejabatKeuangan::className(), ['id' => 'pelaksana_teknik_kegiatan_id']);
    }

    /**
     * Gets query for [[PelaksanaTugas]].
     *
     * @return \yii\db\ActiveQuery|PelaksanaTugasQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasOne(PelaksanaTugas::className(), ['id' => 'pelaksana_tugas_id']);
    }

    /**
     * Gets query for [[ProdukHukum]].
     *
     * @return \yii\db\ActiveQuery|ProdukHukumQuery
     */
    public function getProdukHukum()
    {
        return $this->hasOne(ProdukHukum::className(), ['id' => 'produk_hukum_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[WilayahBerangkat]].
     *
     * @return \yii\db\ActiveQuery|WilayahQuery
     */
    public function getWilayahBerangkat()
    {
        return $this->hasOne(Wilayah::className(), ['kode' => 'wilayah_berangkat']);
    }

    /**
     * Gets query for [[WilayahTujuan]].
     *
     * @return \yii\db\ActiveQuery|WilayahQuery
     */
    public function getWilayahTujuan()
    {
        return $this->hasOne(Wilayah::className(), ['kode' => 'wilayah_tujuan']);
    }

    /**
     * {@inheritdoc}
     * @return SppdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SppdQuery(get_called_class());
    }
}
