<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%produk_hukum}}".
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $tentang
 * @property string|null $pdf_url
 * @property string|null $pdf_lampiran_url
 * @property int|null $public
 * @property int|null $status
 * @property string|null $keterangan
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property Anggaran[] $anggarans
 * @property BesaranBiayaSppd[] $besaranBiayaSppds
 * @property PejabatDaerah[] $pejabatDaerahs
 * @property PejabatKeuangan[] $pejabatKeuangans
 * @property PejabatStruktural[] $pejabatStrukturals
 * @property User $createdBy
 * @property User $updatedBy
 */
class ProdukHukum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%produk_hukum}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tentang'], 'string'],
            [['public', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['public', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nama', 'pdf_url', 'pdf_lampiran_url', 'keterangan'], 'string', 'max' => 255],
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
            'nama' => 'Nama',
            'tentang' => 'Tentang',
            'pdf_url' => 'Pdf Url',
            'pdf_lampiran_url' => 'Pdf Lampiran Url',
            'public' => 'Public',
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
        return $this->hasMany(Anggaran::className(), ['produk_hukum_id' => 'id']);
    }

    /**
     * Gets query for [[BesaranBiayaSppds]].
     *
     * @return \yii\db\ActiveQuery|BesaranBiayaSppdQuery
     */
    public function getBesaranBiayaSppds()
    {
        return $this->hasMany(BesaranBiayaSppd::className(), ['produk_hukum_id' => 'id']);
    }

    /**
     * Gets query for [[PejabatDaerahs]].
     *
     * @return \yii\db\ActiveQuery|PejabatDaerahQuery
     */
    public function getPejabatDaerahs()
    {
        return $this->hasMany(PejabatDaerah::className(), ['produk_hukum_id' => 'id']);
    }

    /**
     * Gets query for [[PejabatKeuangans]].
     *
     * @return \yii\db\ActiveQuery|PejabatKeuanganQuery
     */
    public function getPejabatKeuangans()
    {
        return $this->hasMany(PejabatKeuangan::className(), ['produk_hukum_id' => 'id']);
    }

    /**
     * Gets query for [[PejabatStrukturals]].
     *
     * @return \yii\db\ActiveQuery|PejabatStrukturalQuery
     */
    public function getPejabatStrukturals()
    {
        return $this->hasMany(PejabatStruktural::className(), ['produk_hukum_id' => 'id']);
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
     * @return ProdukHukumQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProdukHukumQuery(get_called_class());
    }
}
