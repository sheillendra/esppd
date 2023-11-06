<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%penduduk}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $nik
 * @property int $jenis_kelamin
 * @property int $status
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property string|null $nama_tanpa_gelar
 * @property string|null $gelar_depan
 * @property string|null $gelar_belakang
 *
 * @property PejabatDaerah[] $pejabatDaerahs
 * @property PelaksanaTugas[] $pelaksanaTugas
 * @property User $user
 * @property User $createdBy
 * @property User $updatedBy
 */
class Penduduk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%penduduk}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'jenis_kelamin', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['user_id', 'jenis_kelamin', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nik', 'jenis_kelamin'], 'required'],
            [['keterangan'], 'string'],
            [['nik'], 'string', 'max' => 16],
            [['nama_tanpa_gelar'], 'string', 'max' => 100],
            [['gelar_depan', 'gelar_belakang'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'nik' => 'Nik',
            'jenis_kelamin' => 'Jenis Kelamin',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'nama_tanpa_gelar' => 'Nama Tanpa Gelar',
            'gelar_depan' => 'Gelar Depan',
            'gelar_belakang' => 'Gelar Belakang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPejabatDaerahs()
    {
        return $this->hasMany(PejabatDaerah::className(), ['penduduk_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasMany(PelaksanaTugas::className(), ['penduduk_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
     * @return PendudukQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendudukQuery(get_called_class());
    }
}
