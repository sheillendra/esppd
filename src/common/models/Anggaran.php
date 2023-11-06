<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%anggaran}}".
 *
 * @property int $id
 * @property int $opd_id
 * @property int $produk_hukum_id
 * @property string $kode_rekening
 * @property float $jumlah
 * @property float|null $saldo
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property Opd $opd
 * @property ProdukHukum $produkHukum
 * @property Rekening $kodeRekening
 * @property User $createdBy
 * @property User $updatedBy
 * @property AnggaranRevisi[] $anggaranRevisis
 * @property Sppd[] $sppds
 */
class Anggaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%anggaran}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['opd_id', 'produk_hukum_id', 'kode_rekening', 'jumlah'], 'required'],
            [['opd_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['opd_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['jumlah', 'saldo'], 'number'],
            [['keterangan'], 'string'],
            [['kode_rekening'], 'string', 'max' => 15],
            [['opd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Opd::className(), 'targetAttribute' => ['opd_id' => 'id']],
            [['produk_hukum_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProdukHukum::className(), 'targetAttribute' => ['produk_hukum_id' => 'id']],
            [['kode_rekening'], 'exist', 'skipOnError' => true, 'targetClass' => Rekening::className(), 'targetAttribute' => ['kode_rekening' => 'kode']],
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
            'produk_hukum_id' => 'Produk Hukum ID',
            'kode_rekening' => 'Kode Rekening',
            'jumlah' => 'Jumlah',
            'saldo' => 'Saldo',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Opd]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpd()
    {
        return $this->hasOne(Opd::className(), ['id' => 'opd_id']);
    }

    /**
     * Gets query for [[ProdukHukum]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdukHukum()
    {
        return $this->hasOne(ProdukHukum::className(), ['id' => 'produk_hukum_id']);
    }

    /**
     * Gets query for [[KodeRekening]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeRekening()
    {
        return $this->hasOne(Rekening::className(), ['kode' => 'kode_rekening']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * Gets query for [[AnggaranRevisis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnggaranRevisis()
    {
        return $this->hasMany(AnggaranRevisi::className(), ['anggaran_id' => 'id']);
    }

    /**
     * Gets query for [[Sppds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSppds()
    {
        return $this->hasMany(Sppd::className(), ['anggaran_id' => 'id']);
    }
}
