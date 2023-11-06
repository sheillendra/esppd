<?php

/* @var $this \yii\web\View */

use sheillendra\jeasyui\components\helpers\Regex;

$this->title = 'Pejabat Struktural';

if (Yii::$app->request->isAjax) {
    $this->context->layout = '//ajax';
    echo $this->renderAjax('_index');
} else {
    $this->params['selectedNav'] = 'nav-pejabat-struktural';
    $this->params['tabOptions']['content'] = preg_replace(Regex::HTML_MINIFIED, ' ', $this->render('_index'));
}
