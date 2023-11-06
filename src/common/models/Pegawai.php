<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pegawai}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $nip
 * @property string $pangkat_golongan_id
 * @property string|null $eselon_id
 * @property int $opd_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property string|null $nama_tanpa_gelar
 * @property string|null $gelar_depan
 * @property string|null $gelar_belakang
 *
 * @property Eselon $eselon
 * @property Opd $opd
 * @property PangkatGolongan $pangkatGolongan
 * @property User $user
 * @property User $createdBy
 * @property User $updatedBy
 * @property PejabatKeuangan[] $pejabatKeuangans
 * @property PejabatStruktural[] $pejabatStrukturals
 * @property PelaksanaTugas[] $pelaksanaTugas
 */
class Pegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pegawai}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'opd_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['user_id', 'opd_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nip', 'pangkat_golongan_id', 'opd_id'], 'required'],
            [['nip', 'gelar_depan', 'gelar_belakang'], 'string', 'max' => 20],
            [['pangkat_golongan_id', 'eselon_id'], 'string', 'max' => 2],
            [['nama_tanpa_gelar'], 'string', 'max' => 100],
            [['eselon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Eselon::className(), 'targetAttribute' => ['eselon_id' => 'kode']],
            [['opd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Opd::className(), 'targetAttribute' => ['opd_id' => 'id']],
            [['pangkat_golongan_id'], 'exist', 'skipOnError' => true, 'targetClass' => PangkatGolongan::className(), 'targetAttribute' => ['pangkat_golongan_id' => 'kode']],
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
            'nip' => 'Nip',
            'pangkat_golongan_id' => 'Pangkat Golongan ID',
            'eselon_id' => 'Eselon ID',
            'opd_id' => 'Opd ID',
            'status' => 'Status',
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
     * Gets query for [[Eselon]].
     *
     * @return \yii\db\ActiveQuery|EselonQuery
     */
    public function getEselon()
    {
        return $this->hasOne(Eselon::className(), ['kode' => 'eselon_id']);
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
     * Gets query for [[PangkatGolongan]].
     *
     * @return \yii\db\ActiveQuery|PangkatGolonganQuery
     */
    public function getPangkatGolongan()
    {
        return $this->hasOne(PangkatGolongan::className(), ['kode' => 'pangkat_golongan_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
     * Gets query for [[PejabatKeuangans]].
     *
     * @return \yii\db\ActiveQuery|PejabatKeuanganQuery
     */
    public function getPejabatKeuangans()
    {
        return $this->hasMany(PejabatKeuangan::className(), ['pegawai_id' => 'id']);
    }

    /**
     * Gets query for [[PejabatStrukturals]].
     *
     * @return \yii\db\ActiveQuery|PejabatStrukturalQuery
     */
    public function getPejabatStrukturals()
    {
        return $this->hasMany(PejabatStruktural::className(), ['pegawai_id' => 'id']);
    }

    /**
     * Gets query for [[PelaksanaTugas]].
     *
     * @return \yii\db\ActiveQuery|PelaksanaTugasQuery
     */
    public function getPelaksanaTugas()
    {
        return $this->hasMany(PelaksanaTugas::className(), ['pegawai_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PegawaiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PegawaiQuery(get_called_class());
    }
}
