<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Penduduk]].
 *
 * @see Penduduk
 */
class PendudukQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Penduduk[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Penduduk|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
