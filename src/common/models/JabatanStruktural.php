<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jabatan_struktural}}".
 *
 * @property int $id
 * @property int|null $opd_id
 * @property string|null $nama
 * @property string|null $nama_2
 * @property string|null $singkatan
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
 * @property PejabatStruktural[] $pejabatStrukturals
 */
class JabatanStruktural extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jabatan_struktural}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['opd_id', 'status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['opd_id', 'status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['nama', 'nama_2'], 'string', 'max' => 255],
            [['singkatan'], 'string', 'max' => 20],
            [['tingkat_sppd'], 'string', 'max' => 1],
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
            'singkatan' => 'Singkatan',
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
     * Gets query for [[BesaranBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|BesaranBiayaSppdQuery
     */
    public function getBesaranBiayaSppds()
    {
        return $this->hasMany(BesaranBiayaSppd::className(), ['jabatan_struktural_id' => 'id']);
    }

    /**
     * Gets query for [[Opd]].
     *
     * @return \yii\db\ActiveQuery|OpdQuery
     */
    public function getOpd()
    {
        return $this->hasOne(Opd::className(), ['id' => 'opd_id']);
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
     * Gets query for [[PejabatStrukturals]].
     *
     * @return \yii\db\ActiveQuery|PejabatStrukturalQuery
     */
    public function getPejabatStrukturals()
    {
        return $this->hasMany(PejabatStruktural::className(), ['jabatan_struktural_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return JabatanStrukturalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JabatanStrukturalQuery(get_called_class());
    }
}
