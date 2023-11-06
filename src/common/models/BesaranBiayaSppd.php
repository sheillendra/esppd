<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%besaran_biaya_sppd}}".
 *
 * @property int $id
 * @property string|null $pangkat_golongan_id
 * @property string|null $eselon_id
 * @property int|null $jabatan_daerah_id
 * @property int|null $jabatan_struktural_id
 * @property int|null $jabatan_fungsional_id
 * @property int|null $kategori_wilayah
 * @property string|null $wilayah_id
 * @property int|null $jenis_biaya_sppd_id
 * @property float $jumlah
 * @property int|null $produk_hukum_id
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property Eselon $eselon
 * @property JabatanDaerah $jabatanDaerah
 * @property JabatanStruktural $jabatanStruktural
 * @property JenisBiayaSppd $jenisBiayaSppd
 * @property PangkatGolongan $pangkatGolongan
 * @property ProdukHukum $produkHukum
 * @property User $createdBy
 * @property User $updatedBy
 * @property Wilayah $wilayah
 */
class BesaranBiayaSppd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%besaran_biaya_sppd}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_daerah_id', 'jabatan_struktural_id', 'jabatan_fungsional_id', 'kategori_wilayah', 'jenis_biaya_sppd_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['jabatan_daerah_id', 'jabatan_struktural_id', 'jabatan_fungsional_id', 'kategori_wilayah', 'jenis_biaya_sppd_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['jumlah'], 'required'],
            [['jumlah'], 'number'],
            [['keterangan'], 'string'],
            [['pangkat_golongan_id', 'eselon_id'], 'string', 'max' => 2],
            [['wilayah_id'], 'string', 'max' => 12],
            [['eselon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Eselon::className(), 'targetAttribute' => ['eselon_id' => 'kode']],
            [['jabatan_daerah_id'], 'exist', 'skipOnError' => true, 'targetClass' => JabatanDaerah::className(), 'targetAttribute' => ['jabatan_daerah_id' => 'id']],
            [['jabatan_struktural_id'], 'exist', 'skipOnError' => true, 'targetClass' => JabatanStruktural::className(), 'targetAttribute' => ['jabatan_struktural_id' => 'id']],
            [['jenis_biaya_sppd_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisBiayaSppd::className(), 'targetAttribute' => ['jenis_biaya_sppd_id' => 'id']],
            [['pangkat_golongan_id'], 'exist', 'skipOnError' => true, 'targetClass' => PangkatGolongan::className(), 'targetAttribute' => ['pangkat_golongan_id' => 'kode']],
            [['produk_hukum_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProdukHukum::className(), 'targetAttribute' => ['produk_hukum_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['wilayah_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wilayah::className(), 'targetAttribute' => ['wilayah_id' => 'kode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pangkat_golongan_id' => 'Pangkat Golongan ID',
            'eselon_id' => 'Eselon ID',
            'jabatan_daerah_id' => 'Jabatan Daerah ID',
            'jabatan_struktural_id' => 'Jabatan Struktural ID',
            'jabatan_fungsional_id' => 'Jabatan Fungsional ID',
            'kategori_wilayah' => 'Kategori Wilayah',
            'wilayah_id' => 'Wilayah ID',
            'jenis_biaya_sppd_id' => 'Jenis Biaya Sppd ID',
            'jumlah' => 'Jumlah',
            'produk_hukum_id' => 'Produk Hukum ID',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
     * Gets query for [[JabatanDaerah]].
     *
     * @return \yii\db\ActiveQuery|JabatanDaerahQuery
     */
    public function getJabatanDaerah()
    {
        return $this->hasOne(JabatanDaerah::className(), ['id' => 'jabatan_daerah_id']);
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
     * Gets query for [[JenisBiayaSppd]].
     *
     * @return \yii\db\ActiveQuery|JenisBiayaSppdQuery
     */
    public function getJenisBiayaSppd()
    {
        return $this->hasOne(JenisBiayaSppd::className(), ['id' => 'jenis_biaya_sppd_id']);
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
     * Gets query for [[Wilayah]].
     *
     * @return \yii\db\ActiveQuery|WilayahQuery
     */
    public function getWilayah()
    {
        return $this->hasOne(Wilayah::className(), ['kode' => 'wilayah_id']);
    }

    /**
     * {@inheritdoc}
     * @return BesaranBiayaSppdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BesaranBiayaSppdQuery(get_called_class());
    }
}
