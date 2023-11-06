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
        'label' => 'Master',
        'options' => ['class' => 'header']
    ],
    [
        'label' => '<i class="zmdi zmdi-city"></i><span>Master</span>',
        'template' => '<a href="javascript:void(0);" class="menu-toggle">{label}</a>',
        'encode' => false,
        'items' => [
            [
                'label' => 'OPD',
                'url' => ['/opd'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'opd',
            ],
            [
                'label' => 'Pangkat Golongan',
                'url' => ['/pangkat-golongan'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'pangkat-golongan',
            ],
            [
                'label' => 'Eselon',
                'url' => ['/eselon'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'eselon',
            ],
            [
                'label' => 'Jabatan Daerah',
                'url' => ['/jabatan-daerah'],
                'active' => $this->params['selectedMenu'] === 'jabatan-daerah',
            ],
            [
                'label' => 'Jabatan Struktural',
                'url' => ['/jabatan-struktural'],
                'active' => $this->params['selectedMenu'] === 'jabatan-struktural',
            ],
            [
                'label' => 'Jabatan Fungsional',
                'url' => ['/jabatan-fungsional'],
                'active' => $this->params['selectedMenu'] === 'jabatan-fungsional',
            ],
            [
                'label' => 'Jabatan Keuangan',
                'url' => ['/jabatan-keuangan'],
                'active' => $this->params['selectedMenu'] === 'jabatan-keuangan',
            ],
            [
                'label' => 'Tahun Anggaran',
                'url' => ['/tahun-anggaran'],
                'active' => $this->params['selectedMenu'] === 'tahun-anggaran',
            ],
            [
                'label' => 'Wilayah',
                'url' => ['/wilayah'],
                'active' => $this->params['selectedMenu'] === 'wilayah',
            ],
            [
                'label' => 'Kategori Biaya SPPD',
                'url' => ['/kategori-biaya-sppd'],
                'active' => $this->params['selectedMenu'] === 'kategori-biaya-sppd',
            ],
            [
                'label' => 'Satuan',
                'url' => ['/satuan'],
                'active' => $this->params['selectedMenu'] === 'satuan',
            ],
        ]
    ],
];