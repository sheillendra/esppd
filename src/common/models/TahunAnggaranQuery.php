<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TahunAnggaran]].
 *
 * @see TahunAnggaran
 */
class TahunAnggaranQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TahunAnggaran[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TahunAnggaran|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
