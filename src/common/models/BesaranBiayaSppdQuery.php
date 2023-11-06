<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BesaranBiayaSppd]].
 *
 * @see BesaranBiayaSppd
 */
class BesaranBiayaSppdQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BesaranBiayaSppd[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BesaranBiayaSppd|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
