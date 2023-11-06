<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PejabatKeuangan]].
 *
 * @see PejabatKeuangan
 */
class PejabatKeuanganQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PejabatKeuangan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PejabatKeuangan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
