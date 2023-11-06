<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pelaksana_tugas}}".
 *
 * @property int $id
 * @property int $surat_tugas_id
 * @property int|null $pegawai_id
 * @property int|null $penduduk_id
 * @property int $status
 * @property int|null $urutan
 * @property string|null $keterangan
 * @property string|null $fix_nama
 * @property string|null $fix_nip
 * @property string|null $fix_jabatan
 * @property string|null $fix_pangkat_golongan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property Pegawai $pegawai
 * @property Penduduk $penduduk
 * @property SuratTugas $suratTugas
 * @property User $createdBy
 * @property User $updatedBy
 * @property Sppd[] $sppds
 */
class PelaksanaTugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pelaksana_tugas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['surat_tugas_id'], 'required'],
            [['surat_tugas_id', 'pegawai_id', 'penduduk_id', 'status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['surat_tugas_id', 'pegawai_id', 'penduduk_id', 'status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['fix_nama', 'fix_nip', 'fix_jabatan', 'fix_pangkat_golongan'], 'string', 'max' => 255],
            [['surat_tugas_id', 'pegawai_id', 'penduduk_id'], 'unique', 'targetAttribute' => ['surat_tugas_id', 'pegawai_id', 'penduduk_id']],
            [['pegawai_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['pegawai_id' => 'id']],
            [['penduduk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Penduduk::className(), 'targetAttribute' => ['penduduk_id' => 'id']],
            [['surat_tugas_id'], 'exist', 'skipOnError' => true, 'targetClass' => SuratTugas::className(), 'targetAttribute' => ['surat_tugas_id' => 'id']],
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
            'surat_tugas_id' => 'Surat Tugas ID',
            'pegawai_id' => 'Pegawai ID',
            'penduduk_id' => 'Penduduk ID',
            'status' => 'Status',
            'urutan' => 'Urutan',
            'keterangan' => 'Keterangan',
            'fix_nama' => 'Fix Nama',
            'fix_nip' => 'Fix Nip',
            'fix_jabatan' => 'Fix Jabatan',
            'fix_pangkat_golongan' => 'Fix Pangkat Golongan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery|PegawaiQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'pegawai_id']);
    }

    /**
     * Gets query for [[Penduduk]].
     *
     * @return \yii\db\ActiveQuery|PendudukQuery
     */
    public function getPenduduk()
    {
        return $this->hasOne(Penduduk::className(), ['id' => 'penduduk_id']);
    }

    /**
     * Gets query for [[SuratTugas]].
     *
     * @return \yii\db\ActiveQuery|SuratTugasQuery
     */
    public function getSuratTugas()
    {
        return $this->hasOne(SuratTugas::className(), ['id' => 'surat_tugas_id']);
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
     * Gets query for [[Sppds]].
     *
     * @return \yii\db\ActiveQuery|SppdQuery
     */
    public function getSppds()
    {
        return $this->hasMany(Sppd::className(), ['pelaksana_tugas_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PelaksanaTugasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PelaksanaTugasQuery(get_called_class());
    }
}
