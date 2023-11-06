<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class PejabatStrukturalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/pejabat-struktural.css',
    ];
    public $js = [
        'js/jeasyui/pejabat-struktural.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
