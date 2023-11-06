<?php

use common\models\UserExt;

$isSuperadmin = Yii::$app->user->can(UserExt::ROLE_SUPERADMIN);

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
        'label' => '<i class="zmdi zmdi-badge-check"></i><span>Surat Tugas</span>',
        'url' => ['/surat-tugas'],
        'active' => $this->params['selectedMenu'] === 'surat-tugas',
        'encode' => false,
    ],
    [
        'label' => '<i class="zmdi zmdi-airplane"></i><span>SPPD</span>',
        'url' => ['/sppd'],
        'active' => $this->params['selectedMenu'] === 'sppd',
        'encode' => false,
    ],
    [
        'label' => 'DATA',
        'options' => ['class' => 'header']
    ],
    [
        'label' => '<i class="zmdi zmdi-format-valign-top"></i><span>Penganggaran</span>',
        'template' => '<a href="javascript:void(0);" class="menu-toggle">{label}</a>',
        'encode' => false,
        'items' => [
            [
                'label' => 'Anggaran',
                'url' => ['/anggaran'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'anggaran',
            ],
            [
                'label' => 'Tahun Anggaran',
                'url' => ['/tahun-anggaran'],
                'activeCssClass' => 'active',
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'tahun-anggaran',
            ],
        ],
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
            //            [
            //                'label' => 'Pejabat Fungsional',
            //                'url' => ['/pejabat-fungsional'],
            //                'activeCssClass' => 'active',
            //                'active' => $this->params['selectedMenu'] === 'pejabat-fungsional',
            //            ],
            [
                'label' => 'Pejabat Keuangan',
                'url' => ['/pejabat-keuangan'],
                'activeCssClass' => 'active',
                'active' => $this->params['selectedMenu'] === 'pejabat-keuangan',
            ],
        ]
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
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'opd',
            ],
            [
                'label' => 'Pangkat Golongan',
                'url' => ['/pangkat-golongan'],
                'activeCssClass' => 'active',
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'pangkat-golongan',
            ],
            [
                'label' => 'Eselon',
                'url' => ['/eselon'],
                'activeCssClass' => 'active',
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'eselon',
            ],
            [
                'label' => 'Jabatan Daerah',
                'url' => ['/jabatan-daerah'],
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'jabatan-daerah',
            ],
            [
                'label' => 'Jabatan Struktural',
                'url' => ['/jabatan-struktural'],
                'active' => $this->params['selectedMenu'] === 'jabatan-struktural',
            ],
            //            [
            //                'label' => 'Jabatan Fungsional',
            //                'url' => ['/jabatan-fungsional'],
            //                'active' => $this->params['selectedMenu'] === 'jabatan-fungsional',
            //            ],
            [
                'label' => 'Jabatan Keuangan',
                'url' => ['/jabatan-keuangan'],
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'jabatan-keuangan',
            ],
            [
                'label' => 'Wilayah',
                'url' => ['/wilayah'],
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'wilayah',
            ],
            [
                'label' => 'Satuan',
                'url' => ['/satuan'],
                'active' => $this->params['selectedMenu'] === 'satuan',
            ],
            [
                'label' => 'Kategori Biaya SPPD',
                'url' => ['/kategori-biaya-sppd'],
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'kategori-biaya-sppd',
            ],
            [
                'label' => 'Jenis Biaya SPPD',
                'url' => ['/jenis-biaya-sppd'],
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'jenis-biaya-sppd',
            ],
            [
                'label' => 'Besaran Biaya SPPD',
                'url' => ['/besaran-biaya-sppd', 'status' => 1],
                'visible' => $isSuperadmin,
                'active' => $this->params['selectedMenu'] === 'besaran-biaya-sppd',
            ],
        ]
    ],
    [
        'label' => '<i class="zmdi zmdi-balance"></i><span>Produk Hukum</span>',
        'url' => ['/produk-hukum'],
        'encode' => false,
        'active' => $this->params['selectedMenu'] === 'produk-hukum'
    ],
];
