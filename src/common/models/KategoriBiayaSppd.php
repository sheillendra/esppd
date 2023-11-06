<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%kategori_biaya_sppd}}".
 *
 * @property int $id
 * @property string $nama
 * @property int|null $status
 * @property int|null $urutan
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property string|null $detail_column
 *
 * @property JenisBiayaSppd[] $jenisBiayaSppds
 * @property User $createdBy
 * @property User $updatedBy
 * @property RincianBiayaSppd[] $rincianBiayaSppds
 */
class KategoriBiayaSppd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%kategori_biaya_sppd}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['detail_column'], 'safe'],
            [['nama'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'urutan' => 'Urutan',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'detail_column' => 'Detail Column',
        ];
    }

    /**
     * Gets query for [[JenisBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|JenisBiayaSppdQuery
     */
    public function getJenisBiayaSppds()
    {
        return $this->hasMany(JenisBiayaSppd::className(), ['kategori_biaya_sppd_id' => 'id']);
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
     * Gets query for [[RincianBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|RincianBiayaSppdQuery
     */
    public function getRincianBiayaSppds()
    {
        return $this->hasMany(RincianBiayaSppd::className(), ['kategori_biaya_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return KategoriBiayaSppdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KategoriBiayaSppdQuery(get_called_class());
    }
}
