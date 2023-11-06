<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Anggaran]].
 *
 * @see Anggaran
 */
class AnggaranQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Anggaran[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Anggaran|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
