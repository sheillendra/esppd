<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProdukHukum]].
 *
 * @see ProdukHukum
 */
class ProdukHukumQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProdukHukum[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProdukHukum|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
