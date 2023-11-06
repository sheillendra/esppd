<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pangkat_golongan}}".
 *
 * @property string $kode
 * @property string|null $pangkat
 * @property string|null $golongan
 * @property string|null $ruang
 * @property string|null $tingkat_sppd
 * @property int|null $status
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property BesaranBiayaSppd[] $besaranBiayaSppds
 * @property User $createdBy
 * @property User $updatedBy
 * @property Pegawai[] $pegawais
 */
class PangkatGolongan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pangkat_golongan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['kode'], 'string', 'max' => 2],
            [['pangkat'], 'string', 'max' => 40],
            [['golongan'], 'string', 'max' => 3],
            [['ruang', 'tingkat_sppd'], 'string', 'max' => 1],
            [['kode'], 'unique'],
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
            'kode' => 'Kode',
            'pangkat' => 'Pangkat',
            'golongan' => 'Golongan',
            'ruang' => 'Ruang',
            'tingkat_sppd' => 'Tingkat Sppd',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBesaranBiayaSppds()
    {
        return $this->hasMany(BesaranBiayaSppd::className(), ['pangkat_golongan_id' => 'kode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawais()
    {
        return $this->hasMany(Pegawai::className(), ['pangkat_golongan_id' => 'kode']);
    }

    /**
     * {@inheritdoc}
     * @return PangkatGolonganQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PangkatGolonganQuery(get_called_class());
    }
}
