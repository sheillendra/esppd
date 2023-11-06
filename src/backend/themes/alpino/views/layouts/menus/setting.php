<?php
/* @var $this \yii\web\View */
/* @var $content string */
$this->params['menuItems'] = [
    [
        'label' => '<i class="zmdi zmdi-home"></i><span>Dashboard</span>',
        'url' => ['/'],
        'encode' => false,
        'active' => $this->params['selectedMenu'] === 'dashboard'
    ],
    [
        'label' => '<i class="zmdi zmdi-account"></i><span>User</span>',
        'url' => ['/user'],
        'encode' => false,
        'active' => $this->params['selectedMenu'] === 'user'
    ],
    [
        'label' => '<i class="zmdi zmdi-settings"></i><span>Setting</span>',
        'template' => '<a href="javascript:void(0);" class="menu-toggle">{label}</a>',
        'encode' => false,
        'items' => [
            [
                'label' => 'General',
                'url' => ['/setting'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'setting-general',
            ],
            [
                'label' => 'Upload Data',
                'url' => ['/setting/initial-data'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'initial-data',
            ],
            [
                'label' => 'Hapus Data',
                'url' => ['/setting/reset-data'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'reset-data',
            ],
        ]
    ],
    [
        'label' => '<i class="zmdi zmdi-settings"></i><span>Cache</span>',
        'template' => '<a href="javascript:void(0);" class="menu-toggle">{label}</a>',
        'encode' => false,
        'items' => [
            [
                'label' => 'Clear Tag Cache',
                'url' => ['/setting/clear-tag-chace'],
            ],
            [
                'label' => 'Clear Schema Cache',
                'url' => ['/setting/clear-schema-cache'],
            ],
            [
                'label' => 'Flush Cache',
                'url' => ['/setting/flush'],
            ],
        ]
    ],
    [
        'label' => '<i class="zmdi zmdi-account"></i><span>Audit</span>',
        'url' => ['/audit'],
        'encode' => false,
        'active' => $this->params['selectedMenu'] === 'audit'
    ],
];