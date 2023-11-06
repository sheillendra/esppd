<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PelaksanaTugas]].
 *
 * @see PelaksanaTugasExt
 */
class PelaksanaTugasQueryExt extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PelaksanaTugasExt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PelaksanaTugasExt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
