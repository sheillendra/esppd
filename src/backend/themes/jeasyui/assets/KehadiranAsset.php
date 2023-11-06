<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

class KehadiranAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/kehadiran.css',
    ];
    public $js = [
        'js/jeasyui/kehadiran.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
