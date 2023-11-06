<?php

namespace common\models;

use Yii;

/**
 * {@inheritdoc}
 */
class RekeningExt extends Rekening
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
        ];
    }
}
