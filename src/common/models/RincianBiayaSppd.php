<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rincian_biaya_sppd}}".
 *
 * @property int $id
 * @property int $sppd_id
 * @property int|null $jenis_biaya_id
 * @property int $kategori_biaya_id
 * @property string $tanggal
 * @property string|null $uraian
 * @property float $volume
 * @property int $satuan_id
 * @property float $harga
 * @property float|null $total
 * @property float|null $total_bukti
 * @property int|null $riil
 * @property string|null $pdf_bukti
 * @property int|null $urutan
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property string|null $detail
 *
 * @property JenisBiayaSppd $jenisBiaya
 * @property KategoriBiayaSppd $kategoriBiaya
 * @property Satuan $satuan
 * @property Sppd $sppd
 * @property User $createdBy
 * @property User $updatedBy
 */
class RincianBiayaSppd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rincian_biaya_sppd}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sppd_id', 'kategori_biaya_id', 'tanggal', 'volume', 'satuan_id', 'harga'], 'required'],
            [['sppd_id', 'jenis_biaya_id', 'kategori_biaya_id', 'satuan_id', 'riil', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['sppd_id', 'jenis_biaya_id', 'kategori_biaya_id', 'satuan_id', 'riil', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['tanggal', 'detail'], 'safe'],
            [['volume', 'harga', 'total', 'total_bukti'], 'number'],
            [['keterangan'], 'string'],
            [['uraian', 'pdf_bukti'], 'string', 'max' => 255],
            [['jenis_biaya_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisBiayaSppd::className(), 'targetAttribute' => ['jenis_biaya_id' => 'id']],
            [['kategori_biaya_id'], 'exist', 'skipOnError' => true, 'targetClass' => KategoriBiayaSppd::className(), 'targetAttribute' => ['kategori_biaya_id' => 'id']],
            [['satuan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Satuan::className(), 'targetAttribute' => ['satuan_id' => 'id']],
            [['sppd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sppd::className(), 'targetAttribute' => ['sppd_id' => 'id']],
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
            'sppd_id' => 'Sppd ID',
            'jenis_biaya_id' => 'Jenis Biaya ID',
            'kategori_biaya_id' => 'Kategori Biaya ID',
            'tanggal' => 'Tanggal',
            'uraian' => 'Uraian',
            'volume' => 'Volume',
            'satuan_id' => 'Satuan ID',
            'harga' => 'Harga',
            'total' => 'Total',
            'total_bukti' => 'Total Bukti',
            'riil' => 'Riil',
            'pdf_bukti' => 'Pdf Bukti',
            'urutan' => 'Urutan',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'detail' => 'Detail',
        ];
    }

    /**
     * Gets query for [[JenisBiaya]].
     *
     * @return \yii\db\ActiveQuery|JenisBiayaSppdQuery
     */
    public function getJenisBiaya()
    {
        return $this->hasOne(JenisBiayaSppd::className(), ['id' => 'jenis_biaya_id']);
    }

    /**
     * Gets query for [[KategoriBiaya]].
     *
     * @return \yii\db\ActiveQuery|KategoriBiayaSppdQuery
     */
    public function getKategoriBiaya()
    {
        return $this->hasOne(KategoriBiayaSppd::className(), ['id' => 'kategori_biaya_id']);
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
     * Gets query for [[Sppd]].
     *
     * @return \yii\db\ActiveQuery|SppdQuery
     */
    public function getSppd()
    {
        return $this->hasOne(Sppd::className(), ['id' => 'sppd_id']);
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
     * @return RincianBiayaSppdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RincianBiayaSppdQuery(get_called_class());
    }
}
