<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * 
 */
class PejabatStrukturalExt extends PejabatStruktural
{

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

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'jabatan_struktural_id' => 'Jabatan Struktural',
            'pegawai_id' => 'Pegawai'
        ]);
    }

    public function canEdit()
    {
        if ($this->suratTugas) {
            return false;
        }

        if ($this->pegawai && $this->pegawai->pelaksanaTugas) {
            return false;
        }
        return true;
    }

    /**
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery|PegawaiQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(PegawaiExt::class, ['id' => 'pegawai_id']);
    }
}
