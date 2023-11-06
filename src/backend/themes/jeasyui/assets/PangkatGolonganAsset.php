<?php

namespace backend\themes\jeasyui\assets;

use yii\web\AssetBundle;

class PangkatGolonganAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jeasyui/pangkat-golongan.css',
    ];
    public $js = [
        'js/jeasyui/pangkat-golongan.js',
    ];
    public $depends = [
        'sheillendra\jeasyui\assets\ExtDgFilterRowAsset',
        'backend\themes\jeasyui\assets\AppAsset'
    ];
}
