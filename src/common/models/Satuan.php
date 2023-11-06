<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%satuan}}".
 *
 * @property int $id
 * @property string|null $nama
 * @property int|null $harian
 * @property int $status
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property JenisBiayaSppd[] $jenisBiayaSppds
 * @property RincianBiayaSppd[] $rincianBiayaSppds
 * @property User $createdBy
 * @property User $updatedBy
 */
class Satuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%satuan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['harian', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['harian', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['nama'], 'string', 'max' => 20],
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
            'nama' => 'Nama',
            'harian' => 'Harian',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[JenisBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|JenisBiayaSppdQuery
     */
    public function getJenisBiayaSppds()
    {
        return $this->hasMany(JenisBiayaSppd::className(), ['satuan_id' => 'id']);
    }

    /**
     * Gets query for [[RincianBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|RincianBiayaSppdQuery
     */
    public function getRincianBiayaSppds()
    {
        return $this->hasMany(RincianBiayaSppd::className(), ['satuan_id' => 'id']);
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
     * @return SatuanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SatuanQuery(get_called_class());
    }
}
