<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

class EselonExt extends Eselon
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
            //'bedezign\yii2\audit\AuditTrailBehavior'
        ];
    }

    public static function dataList()
    {
        return static::find()
            ->select(['kode'])
            ->indexBy('kode')
            ->column();
    }
}
