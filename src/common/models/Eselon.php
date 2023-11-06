<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%eselon}}".
 *
 * @property string $kode
 * @property string|null $eselon
 * @property string|null $pangkat_min_id
 * @property string|null $pangkat_max_id
 * @property string|null $tingkat_sppd
 * @property int|null $status
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property BesaranBiayaSppd[] $besaranBiayaSppds
 * @property PangkatGolongan $pangkatMin
 * @property PangkatGolongan $pangkatMax
 * @property User $createdBy
 * @property User $updatedBy
 * @property Pegawai[] $pegawais
 */
class Eselon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%eselon}}';
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
            [['kode', 'pangkat_min_id', 'pangkat_max_id'], 'string', 'max' => 2],
            [['eselon'], 'string', 'max' => 20],
            [['tingkat_sppd'], 'string', 'max' => 1],
            [['kode'], 'unique'],
            [['pangkat_min_id'], 'exist', 'skipOnError' => true, 'targetClass' => PangkatGolongan::className(), 'targetAttribute' => ['pangkat_min_id' => 'kode']],
            [['pangkat_max_id'], 'exist', 'skipOnError' => true, 'targetClass' => PangkatGolongan::className(), 'targetAttribute' => ['pangkat_max_id' => 'kode']],
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
            'eselon' => 'Eselon',
            'pangkat_min_id' => 'Pangkat Min ID',
            'pangkat_max_id' => 'Pangkat Max ID',
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
     * Gets query for [[BesaranBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|BesaranBiayaSppdQuery
     */
    public function getBesaranBiayaSppds()
    {
        return $this->hasMany(BesaranBiayaSppd::className(), ['eselon_id' => 'kode']);
    }

    /**
     * Gets query for [[PangkatMin]].
     *
     * @return \yii\db\ActiveQuery|PangkatGolonganQuery
     */
    public function getPangkatMin()
    {
        return $this->hasOne(PangkatGolongan::className(), ['kode' => 'pangkat_min_id']);
    }

    /**
     * Gets query for [[PangkatMax]].
     *
     * @return \yii\db\ActiveQuery|PangkatGolonganQuery
     */
    public function getPangkatMax()
    {
        return $this->hasOne(PangkatGolongan::className(), ['kode' => 'pangkat_max_id']);
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
     * Gets query for [[Pegawais]].
     *
     * @return \yii\db\ActiveQuery|PegawaiQuery
     */
    public function getPegawais()
    {
        return $this->hasMany(Pegawai::className(), ['eselon_id' => 'kode']);
    }

    /**
     * {@inheritdoc}
     * @return EselonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EselonQuery(get_called_class());
    }
}
