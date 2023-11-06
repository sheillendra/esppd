<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PejabatStruktural]].
 *
 * @see PejabatStruktural
 */
class PejabatStrukturalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PejabatStruktural[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PejabatStruktural|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
