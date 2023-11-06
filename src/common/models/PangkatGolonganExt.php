<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * @property PegawaiExt $pegawai
 */
class PangkatGolonganExt extends PangkatGolongan
{

    const KODE_NON_PNS = '00';
    const SCENARIO_UPDATE_STAKET = 'staket';

    /**
     * 
     * @return type
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            //'bedezign\yii2\audit\AuditTrailBehavior',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['pangkat_lengkap'] = function () {
            return $this->pangkatLengkap;
        };
        return $fields;
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_UPDATE_STAKET => ['status', 'keterangan'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'created_at' => 'Dibuat pada',
            'createdBy.username' => 'Dibuat oleh',
            'updated_at' => 'Diubah pada',
            'updatedBy.username' => 'Diubah oleh'
        ]);
    }

    public static function dataList()
    {
        return static::find()
            ->select(['kode'])
            ->indexBy('kode')
            ->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBesaranBiayaSppd()
    {
        return $this->hasOne(BesaranBiayaSppdExt::className(), ['pangkat_golongan_id' => 'kode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(PegawaiExt::className(), ['pangkat_golongan_id' => 'kode']);
    }

    public function canEdit()
    {
        if ($this->besaranBiayaSppd) {
            $this->scenario = self::SCENARIO_UPDATE_STAKET;
            return false;
        }

        if ($this->pegawai) {
            $this->scenario = self::SCENARIO_UPDATE_STAKET;
            return false;
        }
        return true;
    }

    public function getPangkatLengkap()
    {
        return $this->pangkat . ' ' . $this->golongan . '/' . $this->ruang;
    }
}
