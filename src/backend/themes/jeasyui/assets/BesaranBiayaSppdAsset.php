<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

class BesaranBiayaSppdAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/besaran-biaya-sppd.css',
    ];
    public $js = [
        'js/jeasyui/besaran-biaya-sppd.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
