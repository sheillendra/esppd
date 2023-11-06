<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%surat_tugas}}".
 *
 * @property int $id
 * @property int|null $pejabat_daerah_id
 * @property int|null $pejabat_struktural_id
 * @property string $tanggal_terbit
 * @property string $nomor
 * @property string|null $tanggal_mulai
 * @property int $jumlah_hari
 * @property string $maksud
 * @property int $status
 * @property string|null $keterangan
 * @property string|null $fix_opd_nama
 * @property string|null $fix_opd_kop_1
 * @property string|null $fix_opd_kop_2
 * @property string|null $fix_opd_kedudukan
 * @property string|null $fix_jabatan
 * @property string|null $fix_nama
 * @property string|null $fix_pangkat
 * @property string|null $fix_nip
 * @property string|null $pdf_filename_blank
 * @property string|null $pdf_filename_barcode
 * @property string|null $pdf_filename_ttd
 * @property string|null $pdf_url_blank
 * @property string|null $pdf_url_barcode
 * @property string|null $pdf_url_ttd
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property PelaksanaTugas[] $pelaksanaTugas
 * @property PejabatDaerah $pejabatDaerah
 * @property PejabatStruktural $pejabatStruktural
 * @property User $createdBy
 * @property User $updatedBy
 */
class SuratTugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%surat_tugas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pejabat_daerah_id', 'pejabat_struktural_id', 'jumlah_hari', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['pejabat_daerah_id', 'pejabat_struktural_id', 'jumlah_hari', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['tanggal_terbit', 'nomor', 'jumlah_hari', 'maksud'], 'required'],
            [['tanggal_terbit', 'tanggal_mulai'], 'safe'],
            [['maksud', 'keterangan'], 'string'],
            [['nomor', 'fix_opd_nama', 'fix_opd_kop_1', 'fix_opd_kop_2', 'fix_opd_kedudukan', 'fix_jabatan', 'fix_nama', 'fix_pangkat', 'fix_nip', 'pdf_url_blank', 'pdf_url_barcode', 'pdf_url_ttd'], 'string', 'max' => 255],
            [['pdf_filename_blank', 'pdf_filename_barcode', 'pdf_filename_ttd'], 'string', 'max' => 40],
            [['pejabat_daerah_id'], 'exist', 'skipOnError' => true, 'targetClass' => PejabatDaerah::className(), 'targetAttribute' => ['pejabat_daerah_id' => 'id']],
            [['pejabat_struktural_id'], 'exist', 'skipOnError' => true, 'targetClass' => PejabatStruktural::className(), 'targetAttribute' => ['pejabat_struktural_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pejabat_daerah_id' => 'Pejabat Daerah ID',
            'pejabat_struktural_id' => 'Pejabat Struktural ID',
            'tanggal_terbit' => 'Tanggal Terbit',
            'nomor' => 'Nomor',
            'tanggal_mulai' => 'Tanggal Mulai',
            'jumlah_hari' => 'Jumlah Hari',
            'maksud' => 'Maksud',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
            'fix_opd_nama' => 'Fix Opd Nama',
            'fix_opd_kop_1' => 'Fix Opd Kop 1',
            'fix_opd_kop_2' => 'Fix Opd Kop 2',
            'fix_opd_kedudukan' => 'Fix Opd Kedudukan',
            'fix_jabatan' => 'Fix Jabatan',
            'fix_nama' => 'Fix Nama',
            'fix_pangkat' => 'Fix Pangkat',
            'fix_nip' => 'Fix Nip',
            'pdf_filename_blank' => 'Pdf Filename Blank',
            'pdf_filename_barcode' => 'Pdf Filename Barcode',
            'pdf_filename_ttd' => 'Pdf Filename Ttd',
            'pdf_url_blank' => 'Pdf Url Blank',
            'pdf_url_barcode' => 'Pdf Url Barcode',
            'pdf_url_ttd' => 'Pdf Url Ttd',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[PelaksanaTugas]].
     *
     * @return \yii\db\ActiveQuery|PelaksanaTugasQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasMany(PelaksanaTugas::className(), ['surat_tugas_id' => 'id']);
    }

    /**
     * Gets query for [[PejabatDaerah]].
     *
     * @return \yii\db\ActiveQuery|PejabatDaerahQuery
     */
    public function getPejabatDaerah()
    {
        return $this->hasOne(PejabatDaerah::className(), ['id' => 'pejabat_daerah_id']);
    }

    /**
     * Gets query for [[PejabatStruktural]].
     *
     * @return \yii\db\ActiveQuery|PejabatStrukturalQuery
     */
    public function getPejabatStruktural()
    {
        return $this->hasOne(PejabatStruktural::className(), ['id' => 'pejabat_struktural_id']);
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
     * {@inheritdoc}
     * @return SuratTugasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SuratTugasQuery(get_called_class());
    }
}
