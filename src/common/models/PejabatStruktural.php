<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pejabat_struktural}}".
 *
 * @property int $id
 * @property int $jabatan_struktural_id
 * @property int $pegawai_id
 * @property int $produk_hukum_id
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property JabatanStruktural $jabatanStruktural
 * @property Pegawai $pegawai
 * @property ProdukHukum $produkHukum
 * @property User $createdBy
 * @property User $updatedBy
 * @property SuratTugas[] $suratTugas
 */
class PejabatStruktural extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pejabat_struktural}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_struktural_id', 'pegawai_id', 'produk_hukum_id'], 'required'],
            [['jabatan_struktural_id', 'pegawai_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['jabatan_struktural_id', 'pegawai_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['jabatan_struktural_id'], 'exist', 'skipOnError' => true, 'targetClass' => JabatanStruktural::className(), 'targetAttribute' => ['jabatan_struktural_id' => 'id']],
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
            'jabatan_struktural_id' => 'Jabatan Struktural ID',
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
     * Gets query for [[JabatanStruktural]].
     *
     * @return \yii\db\ActiveQuery|JabatanStrukturalQuery
     */
    public function getJabatanStruktural()
    {
        return $this->hasOne(JabatanStruktural::className(), ['id' => 'jabatan_struktural_id']);
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
     * Gets query for [[SuratTugas]].
     *
     * @return \yii\db\ActiveQuery|SuratTugasQuery
     */
    public function getSuratTugas()
    {
        return $this->hasMany(SuratTugas::className(), ['pejabat_struktural_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PejabatStrukturalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PejabatStrukturalQuery(get_called_class());
    }
}
