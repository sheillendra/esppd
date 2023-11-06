<?php

/* @var $this yii\web\View */
/* @var $model common\models\SuratTugasExt */

$items = [];
if ($model->status === $model::STATUS_SEDANG_PROSES) {
    $items[] = [
        'label' => 'Siap disahkan',
        'url' => ['siap-disahkan', 'id' => $model->id],
        'linkOptions' => [
            'data' => [
                'confirm' => 'Yakin ingin mengubah status surat tugas ini menjadi "SIAP DISAHKAN"?',
                'method' => 'post',
            ],
        ],
    ];
    $items[] = [
        'label' => 'Ubah',
        'url' => ['update', 'id' => $model->id],
    ];

    if (!$model->pelaksanaTugas) {
        $items[] = [
            'label' => 'Hapus',
            'url' => ['delete', 'id' => $model->id],
            'linkOptions' => [
                'data' => [
                    'confirm' => 'Yakin ingin menghapus surat tugas ini?',
                    'method' => 'post',
                ],
            ],
        ];
    }
} elseif ($model->status === $model::STATUS_PENGESAHAN) {
    $items[] = [
        'label' => 'Terbitkan',
        'url' => ['terbitkan', 'id' => $model->id],
        'linkOptions' => [
            'data' => [
                'confirm' => 'Yakin ingin menerbitkan surat tugas ini?',
                'method' => 'post',
            ],
        ],
    ];
    $items[] = [
        'label' => 'Olah kembali',
        'url' => ['olah-kembali', 'id' => $model->id],
        'linkOptions' => [
            'data' => [
                'confirm' => 'Yakin ingin mengolah kembali surat tugas ini?',
                'method' => 'post',
            ],
        ]
    ];
} elseif ($model->status === $model::STATUS_TERBIT) {
    $items[] = [
        'label' => 'Upload ST TTD',
        'url' => ['upload-ttd', 'id' => $model->id],
    ];
    $items[] = [
        'label' => 'Olah kembali',
        'url' => ['olah-kembali', 'id' => $model->id],
        'linkOptions' => [
            'data' => [
                'confirm' => 'Yakin ingin mengolah kembali surat tugas ini?',
                'method' => 'post',
            ],
        ]
    ];
}

echo $this->render('@app/views/_partials/title_menu', ['items' => $items]);
