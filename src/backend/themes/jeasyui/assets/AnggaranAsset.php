<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

class AnggaranAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/anggaran.css',
    ];
    public $js = [
        'js/jeasyui/anggaran.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
