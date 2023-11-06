<?php

use yii\widgets\Breadcrumbs;
?>
<h2><?php echo $this->title ?></h2>
<?php
echo Breadcrumbs::widget([
    'options' => ['class' => 'breadcrumb padding-0'],
    'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
    'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
    'homeLink' => [
        'label' => '<i class="zmdi zmdi-home"></i>',
        'url' => ['/'],
        'encode' => false
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
