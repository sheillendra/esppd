<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

class EselonAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/eselon.css',
    ];
    public $js = [
        'js/jeasyui/eselon.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
