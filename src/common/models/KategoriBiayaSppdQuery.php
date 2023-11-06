<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[KategoriBiayaSppd]].
 *
 * @see KategoriBiayaSppd
 */
class KategoriBiayaSppdQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return KategoriBiayaSppd[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return KategoriBiayaSppd|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
