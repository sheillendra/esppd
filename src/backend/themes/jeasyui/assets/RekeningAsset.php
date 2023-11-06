<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

class RekeningAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/rekening.css',
    ];
    public $js = [
        'js/jeasyui/rekening.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
