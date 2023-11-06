<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class JabatanKeuanganAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/jabatan-keuangan.css',
    ];
    public $js = [
        'js/jeasyui/jabatan-keuangan.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
