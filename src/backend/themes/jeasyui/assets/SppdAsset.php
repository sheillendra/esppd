<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SppdAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/sppd.css',
    ];
    public $js = [
        'js/jeasyui/sppd.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'sheillendra\jeasyui\assets\ExtDgViewGroupAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
