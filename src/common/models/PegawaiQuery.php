<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Pegawai]].
 *
 * @see Pegawai
 */
class PegawaiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Pegawai[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pegawai|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
