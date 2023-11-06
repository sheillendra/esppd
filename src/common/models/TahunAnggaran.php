<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tahun_anggaran}}".
 *
 * @property int $id
 * @property int|null $tahun
 * @property int|null $status_anggaran
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property Anggaran[] $anggarans
 * @property User $createdBy
 * @property User $updatedBy
 */
class TahunAnggaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tahun_anggaran}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'status_anggaran', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['tahun', 'status_anggaran', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            'tahun' => 'Tahun',
            'status_anggaran' => 'Status Anggaran',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnggarans()
    {
        return $this->hasMany(Anggaran::className(), ['tahun_anggaran_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return TahunAnggaranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TahunAnggaranQuery(get_called_class());
    }
}
