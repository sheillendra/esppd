<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[JabatanStruktural]].
 *
 * @see JabatanStruktural
 */
class JabatanStrukturalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return JabatanStruktural[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JabatanStruktural|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
