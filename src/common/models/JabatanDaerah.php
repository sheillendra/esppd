<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jabatan_daerah}}".
 *
 * @property int $id
 * @property int|null $opd_id
 * @property string $nama
 * @property string $nama_2
 * @property string|null $tingkat_sppd
 * @property int $status
 * @property int|null $urutan
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property BesaranBiayaSppd[] $besaranBiayaSppds
 * @property Opd $opd
 * @property User $createdBy
 * @property User $updatedBy
 * @property PejabatDaerah[] $pejabatDaerahs
 */
class JabatanDaerah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jabatan_daerah}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['opd_id', 'status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['opd_id', 'status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nama', 'nama_2'], 'required'],
            [['keterangan'], 'string'],
            [['nama'], 'string', 'max' => 100],
            [['nama_2', 'tingkat_sppd'], 'string', 'max' => 20],
            [['opd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Opd::className(), 'targetAttribute' => ['opd_id' => 'id']],
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
            'opd_id' => 'Opd ID',
            'nama' => 'Nama',
            'nama_2' => 'Nama 2',
            'tingkat_sppd' => 'Tingkat Sppd',
            'status' => 'Status',
            'urutan' => 'Urutan',
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
        return $this->hasMany(BesaranBiayaSppd::className(), ['jabatan_daerah_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpd()
    {
        return $this->hasOne(Opd::className(), ['id' => 'opd_id']);
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
    public function getPejabatDaerahs()
    {
        return $this->hasMany(PejabatDaerah::className(), ['jabatan_daerah_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return JabatanDaerahQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JabatanDaerahQuery(get_called_class());
    }
}
