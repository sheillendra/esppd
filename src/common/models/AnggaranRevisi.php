<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%anggaran_revisi}}".
 *
 * @property int $id
 * @property string $kode_anggaran
 * @property int $produk_hukum_id
 * @property string $uraian
 * @property float|null $saldo_awal
 * @property float $revisi
 * @property float|null $saldo_akhir
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property Anggaran $kodeAnggaran
 * @property User $createdBy
 * @property User $updatedBy
 */
class AnggaranRevisi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%anggaran_revisi}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_anggaran', 'produk_hukum_id', 'uraian', 'revisi'], 'required'],
            [['produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['saldo_awal', 'revisi', 'saldo_akhir'], 'number'],
            [['kode_anggaran'], 'string', 'max' => 15],
            [['uraian'], 'string', 'max' => 255],
            [['kode_anggaran', 'produk_hukum_id'], 'exist', 'skipOnError' => true, 'targetClass' => Anggaran::className(), 'targetAttribute' => ['kode_anggaran' => 'kode', 'produk_hukum_id' => 'produk_hukum_id']],
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
            'kode_anggaran' => 'Kode Anggaran',
            'produk_hukum_id' => 'Produk Hukum ID',
            'uraian' => 'Uraian',
            'saldo_awal' => 'Saldo Awal',
            'revisi' => 'Revisi',
            'saldo_akhir' => 'Saldo Akhir',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[KodeAnggaran]].
     *
     * @return \yii\db\ActiveQuery|AnggaranQuery
     */
    public function getKodeAnggaran()
    {
        return $this->hasOne(Anggaran::className(), ['kode' => 'kode_anggaran', 'produk_hukum_id' => 'produk_hukum_id']);
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
     * @return AnggaranRevisiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AnggaranRevisiQuery(get_called_class());
    }
}
