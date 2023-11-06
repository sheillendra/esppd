<?php

/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */

$items = [];

if ($model->status === $model::STATUS_SEDANG_PROSES) {
    $items = [
        [
            'label' => 'Ubah / Lengkapi',
            'url' => ['/sppd/update', 'id' => $model->id]
        ],
        [
            'label' => 'Mulai Hitung Biaya',
            'url' => ['/sppd/hitung-biaya', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin ingin mengubah status SPPD menjadi "SEDANG HITUNG BIAYA"?',
                    'method' => 'post',
                ],
            ]
        ],
        [
            'label' => 'Hapus',
            'url' => ['/sppd/delete', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Apakah anda yakin akan menghapus SPPD ini?',
                    'method' => 'post',
                ],
            ]
        ],
    ];
} elseif ($model->status === $model::STATUS_HITUNG_BIAYA) {
    $items = [
        [
            'label' => 'Hapus Biaya',
            'url' => ['/sppd/hapus-biaya', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin ingin menghapus semua biaya?',
                    'method' => 'post',
                ],
            ]
        ],
        [
            'label' => 'Siap disahkan',
            'url' => ['/sppd/siap-disahkan', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin ingin mengubah status SPPD menjadi "SIAP DISAHKAN"?',
                    'method' => 'post',
                ],
            ]
        ]
    ];
} elseif ($model->status === $model::STATUS_PENGESAHAN) {
    $items = [
        [
            'label' => 'Terbitkan',
            'url' => ['/sppd/terbitkan', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin ingin menerbitkan SPPD ini?',
                    'method' => 'post',
                ],
            ]
        ],
        [
            'label' => 'Upload SPPD TTD',
            'url' => ['/sppd/upload-ttd', 'id' => $model->id]
        ],
        [
            'label' => 'Hitung Biaya Kembali',
            'url' => ['/sppd/hitung-kembali', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin ingin menghitung kembali biaya SPPD?',
                    'method' => 'post',
                ],
            ]
        ],
    ];
} elseif ($model->status === $model::STATUS_TERBIT) {
    $items = [
        [
            'label' => 'Hitung Rampung',
            'url' => ['/sppd/hitung-rampung', 'id' => $model->id]
        ],
        [
            'label' => 'Upload Dokumen',
            'url' => ['/sppd/upload-ttd', 'id' => $model->id]
        ],
        [
            'label' => 'Hitung Biaya Kembali',
            'url' => ['/sppd/hitung-kembali', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin ingin menghitung kembali biaya SPPD?',
                    'method' => 'post',
                ],
            ]
        ],
    ];
} elseif ($model->status === $model::STATUS_HITUNG_RAMPUNG) {
    $items = [
        [
            'label' => 'Lengkapi Bukti Kambali',
            'url' => ['/sppd/batal-rampung', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin ingin melengkapi kembali bukti-bukti?',
                    'method' => 'post',
                ],
            ]
        ],
        [
            'label' => 'Upload Dokumen',
            'url' => ['/sppd/upload-ttd', 'id' => $model->id]
        ],
    ];
}

echo $this->render('@app/views/_partials/title_menu', ['items' => $items]);
