<?php

namespace common\models;

/**
 * This is the extend model class for table "{{%auth}}".
 *
 */
class AuthExt extends Auth {

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(UserExt::className(), ['id' => 'user_id']);
    }

}
