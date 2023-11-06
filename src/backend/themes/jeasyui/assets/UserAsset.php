<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class UserAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/user.css',
    ];
    public $js = [
        'js/jeasyui/user-2022012801.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
