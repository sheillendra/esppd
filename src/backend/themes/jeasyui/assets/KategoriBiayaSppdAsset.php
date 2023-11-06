<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

class KategoriBiayaSppdAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/kategori-biaya-sppd.css',
    ];
    public $js = [
        'js/jeasyui/kategori-biaya-sppd.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
