<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SppdPribadiAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/sppd-pribadi.css',
    ];
    public $js = [
        'js/jeasyui/sppd-pribadi-2022012801.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
