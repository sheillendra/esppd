<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PangkatGolongan]].
 *
 * @see PangkatGolongan
 */
class PangkatGolonganQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PangkatGolongan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PangkatGolongan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
