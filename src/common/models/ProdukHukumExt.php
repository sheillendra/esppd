<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;

class ProdukHukumExt extends ProdukHukum
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

    /**
     * PENDING - deprecated
     * @return type
     */
    public static function dataList()
    {
        return static::find()
            ->select(['nama'])
            ->indexBy('id')
            ->column();
    }
}
