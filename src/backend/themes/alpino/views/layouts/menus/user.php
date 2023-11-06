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
        'label' => '<i class="zmdi zmdi-accounts"></i><span>Penduduk</span>',
        'url' => ['/penduduk'],
        'encode' => false,
        'active' => $this->params['selectedMenu'] === 'penduduk'
    ],
    [
        'label' => '<i class="zmdi zmdi-assignment-account"></i><span>Pegawai</span>',
        'url' => ['/pegawai'],
        'encode' => false,
        'active' => $this->params['selectedMenu'] === 'pegawai'
    ],
    
    [
        'label' => '<i class="zmdi zmdi-airline-seat-recline-extra"></i><span>Pejabat</span>',
        'template' => '<a href="javascript:void(0);" class="menu-toggle">{label}</a>',
        'encode' => false,
        'items' => [
            [
                'label' => 'Pejabat Daerah',
                'url' => ['/pejabat-daerah', 'status' => 1],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'pejabat-daerah',
            ],
            [
                'label' => 'Pejabat Struktural',
                'url' => ['/pejabat-struktural'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'pejabat-struktural',
            ],
            [
                'label' => 'Pejabat Keuangan',
                'url' => ['/pejabat-keuangan'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'pejabat-keuangan',
            ],
        ]
    ],
    [
        'label' => '<i class="zmdi zmdi-account"></i><span>User</span>',
        'template' => '<a href="javascript:void(0);" class="menu-toggle">{label}</a>',
        'encode' => false,
        'items' => [
            [
                'label' => 'List',
                'url' => ['/user'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'user',
            ],
        ]
    ],
];