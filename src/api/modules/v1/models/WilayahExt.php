<?php

namespace api\modules\v1\models;


class WilayahExt extends \common\models\WilayahExt
{
    public function extraFields()
    {
        return ['kodeInduk', 'wilayahs'];
    }

    /**
     * Gets query for [[Wilayahs]].
     *
     * @return \yii\db\ActiveQuery|WilayahQuery
     */
    public function getWilayahs()
    {
        return $this->hasMany(self::class, ['kode_induk' => 'kode']);
    }
}
