<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RincianBiayaSppd]].
 *
 * @see RincianBiayaSppd
 */
class RincianBiayaSppdQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RincianBiayaSppd[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RincianBiayaSppd|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
