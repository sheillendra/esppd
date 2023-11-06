<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%jenis_biaya_sppd}}".
 *
 * @property int $id
 * @property int|null $kategori_biaya_sppd_id
 * @property int|null $satuan_id
 * @property string|null $nama
 * @property int|null $pembuktian
 * @property int|null $pergi_pulang
 * @property int|null $status
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property BesaranBiayaSppd[] $besaranBiayaSppds
 * @property KategoriBiayaSppd $kategoriBiayaSppd
 * @property Satuan $satuan
 * @property User $createdBy
 * @property User $updatedBy
 * @property RincianBiayaSppd[] $rincianBiayaSppds
 */
class JenisBiayaSppd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jenis_biaya_sppd}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_biaya_sppd_id', 'satuan_id', 'pembuktian', 'pergi_pulang', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['kategori_biaya_sppd_id', 'satuan_id', 'pembuktian', 'pergi_pulang', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'string'],
            [['nama'], 'string', 'max' => 100],
            [['kategori_biaya_sppd_id'], 'exist', 'skipOnError' => true, 'targetClass' => KategoriBiayaSppd::className(), 'targetAttribute' => ['kategori_biaya_sppd_id' => 'id']],
            [['satuan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Satuan::className(), 'targetAttribute' => ['satuan_id' => 'id']],
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
            'kategori_biaya_sppd_id' => 'Kategori Biaya Sppd ID',
            'satuan_id' => 'Satuan ID',
            'nama' => 'Nama',
            'pembuktian' => 'Pembuktian',
            'pergi_pulang' => 'Pergi Pulang',
            'status' => 'Status',
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
        return $this->hasMany(BesaranBiayaSppd::className(), ['jenis_biaya_sppd_id' => 'id']);
    }

    /**
     * Gets query for [[KategoriBiayaSppd]].
     *
     * @return \yii\db\ActiveQuery|KategoriBiayaSppdQuery
     */
    public function getKategoriBiayaSppd()
    {
        return $this->hasOne(KategoriBiayaSppd::className(), ['id' => 'kategori_biaya_sppd_id']);
    }

    /**
     * Gets query for [[Satuan]].
     *
     * @return \yii\db\ActiveQuery|SatuanQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(Satuan::className(), ['id' => 'satuan_id']);
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
     * Gets query for [[RincianBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|RincianBiayaSppdQuery
     */
    public function getRincianBiayaSppds()
    {
        return $this->hasMany(RincianBiayaSppd::className(), ['jenis_biaya_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return JenisBiayaSppdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new JenisBiayaSppdQuery(get_called_class());
    }
}
