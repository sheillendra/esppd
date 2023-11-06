<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

/**
 * {@inheritdoc}
 */
class SatuanExt extends Satuan
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

    public static function dataList()
    {
        return static::find()
            ->select(['nama'])
            ->indexBy('id')
            ->column();
    }
}
