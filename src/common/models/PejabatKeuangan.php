<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pejabat_keuangan}}".
 *
 * @property int $id
 * @property int $opd_id
 * @property int $jabatan_keuangan_id
 * @property int $pegawai_id
 * @property int|null $produk_hukum_id
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property JabatanKeuangan $jabatanKeuangan
 * @property Opd $opd
 * @property Pegawai $pegawai
 * @property ProdukHukum $produkHukum
 * @property User $createdBy
 * @property User $updatedBy
 * @property Sppd[] $sppds
 * @property Sppd[] $sppds0
 */
class PejabatKeuangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pejabat_keuangan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['opd_id', 'jabatan_keuangan_id', 'pegawai_id'], 'required'],
            [['opd_id', 'jabatan_keuangan_id', 'pegawai_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['opd_id', 'jabatan_keuangan_id', 'pegawai_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['jabatan_keuangan_id'], 'exist', 'skipOnError' => true, 'targetClass' => JabatanKeuangan::className(), 'targetAttribute' => ['jabatan_keuangan_id' => 'id']],
            [['opd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Opd::className(), 'targetAttribute' => ['opd_id' => 'id']],
            [['pegawai_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['pegawai_id' => 'id']],
            [['produk_hukum_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProdukHukum::className(), 'targetAttribute' => ['produk_hukum_id' => 'id']],
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
            'jabatan_keuangan_id' => 'Jabatan Keuangan ID',
            'pegawai_id' => 'Pegawai ID',
            'produk_hukum_id' => 'Produk Hukum ID',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[JabatanKeuangan]].
     *
     * @return \yii\db\ActiveQuery|JabatanKeuanganQuery
     */
    public function getJabatanKeuangan()
    {
        return $this->hasOne(JabatanKeuangan::className(), ['id' => 'jabatan_keuangan_id']);
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
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery|PegawaiQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'pegawai_id']);
    }

    /**
     * Gets query for [[ProdukHukum]].
     *
     * @return \yii\db\ActiveQuery|ProdukHukumQuery
     */
    public function getProdukHukum()
    {
        return $this->hasOne(ProdukHukum::className(), ['id' => 'produk_hukum_id']);
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
     * Gets query for [[Sppds]].
     *
     * @return \yii\db\ActiveQuery|SppdQuery
     */
    public function getSppds()
    {
        return $this->hasMany(Sppd::className(), ['bendahara_pengeluaran_id' => 'id']);
    }

    /**
     * Gets query for [[Sppds0]].
     *
     * @return \yii\db\ActiveQuery|SppdQuery
     */
    public function getSppds0()
    {
        return $this->hasMany(Sppd::className(), ['pelaksana_teknik_kegiatan_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PejabatKeuanganQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PejabatKeuanganQuery(get_called_class());
    }
}
