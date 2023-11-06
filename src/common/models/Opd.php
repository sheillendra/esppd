<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%opd}}".
 *
 * @property int $id
 * @property string $kode
 * @property string|null $kode_wilayah
 * @property string $nama
 * @property string $singkatan
 * @property string $baris_kop_1
 * @property string $baris_kop_2
 * @property string $text_kedudukan
 * @property int|null $status
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $induk_id
 *
 * @property Anggaran[] $anggarans
 * @property JabatanDaerah[] $jabatanDaerahs
 * @property JabatanStruktural[] $jabatanStrukturals
 * @property Opd $induk
 * @property Opd[] $opds
 * @property User $createdBy
 * @property User $updatedBy
 * @property Wilayah $kodeWilayah
 * @property Pegawai[] $pegawais
 * @property PejabatKeuangan[] $pejabatKeuangans
 */
class Opd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%opd}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama', 'singkatan', 'baris_kop_1', 'baris_kop_2', 'text_kedudukan'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'induk_id'], 'default', 'value' => null],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'induk_id'], 'integer'],
            [['keterangan'], 'string'],
            [['kode'], 'string', 'max' => 25],
            [['kode_wilayah'], 'string', 'max' => 12],
            [['nama'], 'string', 'max' => 100],
            [['singkatan'], 'string', 'max' => 30],
            [['baris_kop_1', 'baris_kop_2'], 'string', 'max' => 255],
            [['text_kedudukan'], 'string', 'max' => 20],
            [['induk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Opd::className(), 'targetAttribute' => ['induk_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['kode_wilayah'], 'exist', 'skipOnError' => true, 'targetClass' => Wilayah::className(), 'targetAttribute' => ['kode_wilayah' => 'kode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'kode_wilayah' => 'Kode Wilayah',
            'nama' => 'Nama',
            'singkatan' => 'Singkatan',
            'baris_kop_1' => 'Baris Kop 1',
            'baris_kop_2' => 'Baris Kop 2',
            'text_kedudukan' => 'Text Kedudukan',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'induk_id' => 'Induk ID',
        ];
    }

    /**
     * Gets query for [[Anggarans]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getAnggarans()
    {
        return $this->hasMany(Anggaran::className(), ['opd_id' => 'id']);
    }

    /**
     * Gets query for [[JabatanDaerahs]].
     *
     * @return \yii\db\ActiveQuery|JabatanDaerahQuery
     */
    public function getJabatanDaerahs()
    {
        return $this->hasMany(JabatanDaerah::className(), ['opd_id' => 'id']);
    }

    /**
     * Gets query for [[JabatanStrukturals]].
     *
     * @return \yii\db\ActiveQuery|JabatanStrukturalQuery
     */
    public function getJabatanStrukturals()
    {
        return $this->hasMany(JabatanStruktural::className(), ['opd_id' => 'id']);
    }

    /**
     * Gets query for [[Induk]].
     *
     * @return \yii\db\ActiveQuery|OpdQuery
     */
    public function getInduk()
    {
        return $this->hasOne(Opd::className(), ['id' => 'induk_id']);
    }

    /**
     * Gets query for [[Opds]].
     *
     * @return \yii\db\ActiveQuery|OpdQuery
     */
    public function getOpds()
    {
        return $this->hasMany(Opd::className(), ['induk_id' => 'id']);
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
     * Gets query for [[KodeWilayah]].
     *
     * @return \yii\db\ActiveQuery|WilayahQuery
     */
    public function getKodeWilayah()
    {
        return $this->hasOne(Wilayah::className(), ['kode' => 'kode_wilayah']);
    }

    /**
     * Gets query for [[Pegawais]].
     *
     * @return \yii\db\ActiveQuery|PegawaiQuery
     */
    public function getPegawais()
    {
        return $this->hasMany(Pegawai::className(), ['opd_id' => 'id']);
    }

    /**
     * Gets query for [[PejabatKeuangans]].
     *
     * @return \yii\db\ActiveQuery|PejabatKeuanganQuery
     */
    public function getPejabatKeuangans()
    {
        return $this->hasMany(PejabatKeuangan::className(), ['opd_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OpdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpdQuery(get_called_class());
    }
}
