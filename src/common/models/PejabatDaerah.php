<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pejabat_daerah}}".
 *
 * @property int $id
 * @property int $jabatan_daerah_id
 * @property int $penduduk_id
 * @property int $produk_hukum_id
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property JabatanDaerah $jabatanDaerah
 * @property Penduduk $penduduk
 * @property ProdukHukum $produkHukum
 * @property User $createdBy
 * @property User $updatedBy
 * @property SuratTugas[] $suratTugas
 */
class PejabatDaerah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pejabat_daerah}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_daerah_id', 'penduduk_id', 'produk_hukum_id'], 'required'],
            [['jabatan_daerah_id', 'penduduk_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['jabatan_daerah_id', 'penduduk_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['jabatan_daerah_id'], 'exist', 'skipOnError' => true, 'targetClass' => JabatanDaerah::className(), 'targetAttribute' => ['jabatan_daerah_id' => 'id']],
            [['penduduk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Penduduk::className(), 'targetAttribute' => ['penduduk_id' => 'id']],
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
            'jabatan_daerah_id' => 'Jabatan Daerah ID',
            'penduduk_id' => 'Penduduk ID',
            'produk_hukum_id' => 'Produk Hukum ID',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[JabatanDaerah]].
     *
     * @return \yii\db\ActiveQuery|JabatanDaerahQuery
     */
    public function getJabatanDaerah()
    {
        return $this->hasOne(JabatanDaerah::className(), ['id' => 'jabatan_daerah_id']);
    }

    /**
     * Gets query for [[Penduduk]].
     *
     * @return \yii\db\ActiveQuery|PendudukQuery
     */
    public function getPenduduk()
    {
        return $this->hasOne(Penduduk::className(), ['id' => 'penduduk_id']);
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
        return $this->hasMany(SuratTugas::className(), ['pejabat_daerah_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PejabatDaerahQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PejabatDaerahQuery(get_called_class());
    }
}
