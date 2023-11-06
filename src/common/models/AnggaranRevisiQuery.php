<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AnggaranRevisi]].
 *
 * @see AnggaranRevisi
 */
class AnggaranRevisiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AnggaranRevisi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AnggaranRevisi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
