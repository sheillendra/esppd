<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jabatan_keuangan}}".
 *
 * @property int $id
 * @property string $nama
 * @property string $singkatan
 * @property int $urutan
 * @property int $status
 * @property string $keterangan
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class JabatanKeuangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jabatan_keuangan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['urutan', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['urutan', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['nama'], 'string', 'max' => 255],
            [['singkatan'], 'string', 'max' => 20],
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
            'singkatan' => 'Singkatan',
            'urutan' => 'Urutan',
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
     * {@inheritdoc}
     * @return JabatanKeuanganQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JabatanKeuanganQuery(get_called_class());
    }
}
