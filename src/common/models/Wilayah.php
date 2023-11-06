<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%wilayah}}".
 *
 * @property string $kode
 * @property string|null $kode_induk
 * @property string|null $kode_kemendagri
 * @property string|null $nama
 * @property int|null $ibukota
 * @property int|null $level 1: desa; 2: kecamatan; 3: kabupaten/kota; 4: provinsi; 5. negara
 * @property int|null $kategori 0: induk 1: dalam daerah; 2: satu provinsi; 3: luar provinsi 4: luar negeri
 * @property string|null $keterangan
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property BesaranBiayaSppd[] $besaranBiayaSppds
 * @property Opd[] $opds
 * @property Sppd[] $sppds
 * @property Sppd[] $sppds0
 * @property User $createdBy
 * @property User $updatedBy
 * @property Wilayah $kodeInduk
 * @property Wilayah[] $wilayahs
 */
class Wilayah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wilayah}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode'], 'required'],
            [['ibukota', 'level', 'kategori', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['ibukota', 'level', 'kategori', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['kode', 'kode_induk'], 'string', 'max' => 12],
            [['kode_kemendagri'], 'string', 'max' => 10],
            [['nama'], 'string', 'max' => 150],
            [['kode'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['kode_induk'], 'exist', 'skipOnError' => true, 'targetClass' => Wilayah::className(), 'targetAttribute' => ['kode_induk' => 'kode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'kode_induk' => 'Kode Induk',
            'kode_kemendagri' => 'Kode Kemendagri',
            'nama' => 'Nama',
            'ibukota' => 'Ibukota',
            'level' => 'Level',
            'kategori' => 'Kategori',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[BesaranBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|BesaranBiayaSppdQuery
     */
    public function getBesaranBiayaSppds()
    {
        return $this->hasMany(BesaranBiayaSppd::className(), ['wilayah_id' => 'kode']);
    }

    /**
     * Gets query for [[Opds]].
     *
     * @return \yii\db\ActiveQuery|OpdQuery
     */
    public function getOpds()
    {
        return $this->hasMany(Opd::className(), ['kode_wilayah' => 'kode']);
    }

    /**
     * Gets query for [[Sppds]].
     *
     * @return \yii\db\ActiveQuery|SppdQuery
     */
    public function getSppds()
    {
        return $this->hasMany(Sppd::className(), ['wilayah_berangkat' => 'kode']);
    }

    /**
     * Gets query for [[Sppds0]].
     *
     * @return \yii\db\ActiveQuery|SppdQuery
     */
    public function getSppds0()
    {
        return $this->hasMany(Sppd::className(), ['wilayah_tujuan' => 'kode']);
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
     * Gets query for [[KodeInduk]].
     *
     * @return \yii\db\ActiveQuery|WilayahQuery
     */
    public function getKodeInduk()
    {
        return $this->hasOne(Wilayah::className(), ['kode' => 'kode_induk']);
    }

    /**
     * Gets query for [[Wilayahs]].
     *
     * @return \yii\db\ActiveQuery|WilayahQuery
     */
    public function getWilayahs()
    {
        return $this->hasMany(Wilayah::className(), ['kode_induk' => 'kode']);
    }

    /**
     * {@inheritdoc}
     * @return WilayahQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WilayahQuery(get_called_class());
    }
}
