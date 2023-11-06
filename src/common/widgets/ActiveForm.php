<?php

namespace common\widgets;

/**
 * {@inheritdoc}
 */
class ActiveForm extends \yii\widgets\ActiveForm {

    /**
     * {@inheritdoc}
     */
    public $fieldClass = 'common\widgets\ActiveField';

    /**
     * {@inheritdoc}
     * @return ActiveField
     */
    public function field($model, $attribute, $options = array()) {
        return parent::field($model, $attribute, $options);
    }

}
