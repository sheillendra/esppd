<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/..';
    public $baseUrl = '@web/..';
    public $css = [
        'css/jeasyui/app.css',
    ];
    public $js = [
        'js/jeasyui/app-2022012801.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\YiiEasyUIAsset'
    ];
}
