<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Rekening]].
 *
 * @see Rekening
 */
class RekeningQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Rekening[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Rekening|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
