<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rekening}}".
 *
 * @property string $kode
 * @property string $nama
 * @property string|null $kode_induk
 * @property int|null $status
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property Anggaran[] $anggarans
 * @property Rekening $kodeInduk
 * @property Rekening[] $rekenings
 * @property User $createdBy
 * @property User $updatedBy
 */
class Rekening extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rekening}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['kode', 'kode_induk'], 'string', 'max' => 15],
            [['nama'], 'string', 'max' => 255],
            [['kode'], 'unique'],
            [['kode_induk'], 'exist', 'skipOnError' => true, 'targetClass' => Rekening::className(), 'targetAttribute' => ['kode_induk' => 'kode']],
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
            'nama' => 'Nama',
            'kode_induk' => 'Kode Induk',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Anggarans]].
     *
     * @return \yii\db\ActiveQuery|AnggaranQuery
     */
    public function getAnggarans()
    {
        return $this->hasMany(Anggaran::className(), ['kode_rekening' => 'kode']);
    }

    /**
     * Gets query for [[KodeInduk]].
     *
     * @return \yii\db\ActiveQuery|RekeningQuery
     */
    public function getKodeInduk()
    {
        return $this->hasOne(Rekening::className(), ['kode' => 'kode_induk']);
    }

    /**
     * Gets query for [[Rekenings]].
     *
     * @return \yii\db\ActiveQuery|RekeningQuery
     */
    public function getRekenings()
    {
        return $this->hasMany(Rekening::className(), ['kode_induk' => 'kode']);
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
     * @return RekeningQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RekeningQuery(get_called_class());
    }
}
