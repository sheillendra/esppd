<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

class JabatanDaerahExt extends JabatanDaerah
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
            'opd_id' => 'OPD',
            'nama' => 'Nama Jabatan',
            'created_at' => 'Dibuat pada tanggal',
            'createdBy.username' => 'Oleh',
            'updated_at' => 'Diubah terakhir pada',
            'updatedBy.username' => 'Oleh',
        ]);
    }

    public static function dataList()
    {
        return static::find()
            ->select(['nama'])
            ->indexBy('id')
            ->column();
    }
}
