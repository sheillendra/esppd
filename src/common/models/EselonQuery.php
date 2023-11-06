<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Eselon]].
 *
 * @see Eselon
 */
class EselonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Eselon[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Eselon|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
