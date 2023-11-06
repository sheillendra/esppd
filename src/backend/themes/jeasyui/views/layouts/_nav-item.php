<?php

use common\models\UserExt;
use yii\helpers\Url;

/* @var $this \yii\web\View */

$this->params['defaultSelectedNav'] = 'nav-pegawai';
$menus = [
    [
        'text' => 'Pribadi',
        'iconCls' => 'icon-demo',
        'children' => [
            [
                'id' => 'nav-profile',
                'text' => 'Profile',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/profile']),
                ]
            ],
            [
                'id' => 'nav-surat-tugas-pribadi',
                'text' => 'Surat Tugas',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/surat-tugas-pribadi']),
                ]
            ],
            [
                'id' => 'nav-sppd-pribadi',
                'text' => 'SPPD',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/sppd-pribadi']),
                ]
            ],
        ]
    ],
];

if (Yii::$app->user->can(UserExt::ROLE_ADMIN_OPD)) {
    $kelola = [
        [
            'id' => 'nav-surat-tugas',
            'text' => 'Surat Tugas',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/surat-tugas']),
            ]
        ],
        [
            'id' => 'nav-sppd',
            'text' => 'SPPD',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/sppd']),
            ]
        ],
        [
            'id' => 'nav-anggaran',
            'text' => 'Anggaran',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/anggaran']),
            ]
        ],
        [
            'id' => 'nav-pegawai',
            'text' => 'Pegawai',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/pegawai']),
            ]
        ],
        [
            'id' => 'nav-penduduk',
            'text' => 'Penduduk',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/penduduk']),
            ]
        ],
        [
            'id' => 'nav-user',
            'text' => 'Pengguna',
            'iconCls' => 'icon-group',
            'attributes' => [
                'url' => Url::to(['/user']),
            ]
        ],
        [
            'id' => 'nav-produk-hukum',
            'text' => 'Produk Hukum',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/produk-hukum']),
            ]
        ],
        [
            'id' => 'nav-pejabat-daerah',
            'text' => 'Pejabat Daerah',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/pejabat-daerah']),
            ]
        ],
        [
            'id' => 'nav-pejabat-struktural',
            'text' => 'Pejabat Struktural',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/pejabat-struktural']),
            ]
        ],
    ];

    $master = [

    ];

    if (Yii::$app->user->can(UserExt::ROLE_ADMIN)) {
        $kelola = array_merge($kelola, [
            [
                'id' => 'nav-pejabat-keuangan',
                'text' => 'Pejabat Keuangan',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/pejabat-keuangan']),
                ]
            ],
            [
                'id' => 'nav-besaran-biaya-sppd',
                'text' => 'Besaran Biaya SPPD',
                'iconCls' => 'icon-group',
                'attributes' => [
                    'url' => Url::to(['/besaran-biaya-sppd']),
                ]
            ],
        ]);

        $master = array_merge($master, [
            [
                'id' => 'nav-pangkat-golongan',
                'text' => 'Pangkat Golongan',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/pangkat-golongan']),
                ]
            ],
            [
                'id' => 'nav-eselon',
                'text' => 'Eselon',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/eselon']),
                ]
            ],
            [
                'id' => 'nav-wilayah',
                'text' => 'Wilayah',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/wilayah']),
                ]
            ],
            [
                'id' => 'nav-opd',
                'text' => 'OPD',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/opd']),
                ]
            ],
            [
                'id' => 'nav-jabatan-daerah',
                'text' => 'Jabatan Daerah',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/jabatan-daerah']),
                ]
            ],
            [
                'id' => 'nav-jabatan-struktural',
                'text' => 'Jabatan Struktural',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/jabatan-struktural']),
                ]
            ],
            [
                'id' => 'nav-jabatan-fungsional',
                'text' => 'Jabatan Fungsional',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/jabatan-fungsional']),
                ]
            ],
            [
                'id' => 'nav-jabatan-keuangan',
                'text' => 'Jabatan Keuangan',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/jabatan-keuangan']),
                ]
            ],
            [
                'id' => 'nav-kategori-biaya-sppd',
                'text' => 'Kategori & Jenis Biaya',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/kategori-biaya-sppd']),
                ]
            ],
            [
                'id' => 'nav-rekening',
                'text' => 'Rekening',
                'iconCls' => 'icon-layout-content',
                'attributes' => [
                    'url' => Url::to(['/rekening']),
                ]
            ],
        ]);
    }

    $menus[] = [
        'text' => 'Kelola',
        'iconCls' => 'icon-demo',
        'children' => $kelola
    ];

    $menus[] = [
        'text' => 'Master',
        'iconCls' => 'icon-demo',
        'children' => $master
    ];


    $setting = [
        // [
        //     'id' => 'nav-setting',
        //     'text' => 'General',
        //     'iconCls' => 'icon-cog-edit',
        //     'attributes' => [
        //         'url' => Url::to(['/jeasyui/setting']),
        //     ]
        // ],
        // [
        //     'id' => 'nav-setting-rbac',
        //     'text' => 'Access Management',
        //     'iconCls' => 'icon-group-gear',
        //     'attributes' => [
        //         'url' => Url::to(['/jeasyui/setting-rbac']),
        //     ]
        // ]
    ];

    if (Yii::$app->user->can(UserExt::ROLE_SUPERADMIN)) {
        $setting[] = [
            'id' => 'nav-initial-data',
            'text' => 'Data Awal',
            'iconCls' => 'icon-layout-content',
            'attributes' => [
                'url' => Url::to(['/setting/initial-data']),
            ]
        ];
    }

    $menus[] = [
        'text' => 'Setting',
        'iconCls' => 'icon-cog',
        'children' => $setting
    ];
}


return $menus;
