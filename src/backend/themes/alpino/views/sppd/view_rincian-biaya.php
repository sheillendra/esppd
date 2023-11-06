<?php
/* @var $this yii\web\View */
/* @var $model common\models\SppdExt */
/* @var $items common\models\RincianBiayaSppdExt */

use yii\helpers\Html;
use common\models\KategoriBiayaSppdExt;
?>
<div class="card">
    <div class="header">
        <h2><strong>Rincian</strong> Biaya<small>*Untuk memulai menghitung biaya, status SPPD harus diubah menjadi "<?php echo $model::LABEL_STATUS[$model::STATUS_HITUNG_BIAYA] ?>"</small> </h2>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table style="width: 100%">
                <?php
                $total = 0;
                $totalBukti = 0;
                foreach (KategoriBiayaSppdExt::dataList() as $k => $v):
                    $subtotal = 0;
                    $subtotalBukti = 0;
                    ?>
                    <?php if ($model->status >= $model::STATUS_HITUNG_BIAYA): ?>
                        <tr>
                            <th><?php echo $v ?>
                                <?php if ($model->status === $model::STATUS_HITUNG_BIAYA): ?>
                                    - <small>
                                        <?php echo Html::a('Tambah', ['/rincian-biaya-sppd/create', 'sid' => $model->id, 'kid' => $k]) ?>
                                    </small>
                                <?php endif; ?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <table style="width: 100%; font-size: 12px" class="table table-bordered table-condensed table-dark table-hover">
                                    <tr>
                                        <th></th>
                                        <th>Tanggal</th>
                                        <th>Uraian</th>
                                        <th>QTY</th>
                                        <th>Satuan</th>
                                        <th>Biaya</th>
                                        <th>Total</th>
                                        <th>Bukti</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    <?php
                                    if (isset($items[$k])):
                                        ?>
                                        <?php
                                        foreach ($items[$k]['row'] as $kk => $vv):
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo Html::a(
                                                            html::tag('i', '', ['class' => 'zmdi zmdi-eye'])
                                                            , ['/rincian-biaya-sppd/view', 'id' => $vv['id']]
                                                            , ['title' => 'Lihat Detail']) . '&nbsp;'
                                                    ?>

                                                    <?php if ($vv['jenis_biaya_id'] || $model->status > $model::STATUS_PENGESAHAN): ?>
                                                        <?php if ($model->status >= $model::STATUS_TERBIT && $model->status < $model::STATUS_HITUNG_RAMPUNG): ?>
                                                            <?php if (!$vv['riil']): ?>
                                                                <?php
                                                                echo Html::a(
                                                                        html::tag('i', '', ['class' => 'zmdi zmdi-upload'])
                                                                        , ['/rincian-biaya-sppd/upload-bukti', 'id' => $vv['id']]
                                                                        , ['title' => 'Upload bukti'])
                                                                ?> &nbsp;
                                                                <?php
                                                                echo Html::a(
                                                                        html::tag('i', '', ['class' => 'zmdi zmdi-layers-off',])
                                                                        , ['/rincian-biaya-sppd/biaya-riil', 'id' => $vv['id'],]
                                                                        , ['title' => 'Masuk Daftar Riil',
                                                                    'data' => [
                                                                        'method' => 'post',
                                                                        'confirm' => 'Yakin akan menjadikan ini biaya riil?',
                                                                    ],
                                                                ]);
                                                                ?>
                                                            <?php else: ?>
                                                                <?php
                                                                echo Html::a(
                                                                        html::tag('i', '', ['class' => 'zmdi zmdi-layers',])
                                                                        , ['/rincian-biaya-sppd/biaya-non-riil', 'id' => $vv['id'],]
                                                                        , ['title' => 'Keluar Daftar Riil',
                                                                    'data' => [
                                                                        'method' => 'post',
                                                                        'confirm' => 'Yakin akan menjadikan ini biaya non riil?',
                                                                    ],
                                                                ]);
                                                                ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php elseif ($model->status === $model::STATUS_HITUNG_BIAYA): ?>
                                                        <?php echo Html::a(html::tag('i', '', ['class' => 'zmdi zmdi-edit']), ['/rincian-biaya-sppd/update', 'id' => $vv['id']]) ?>&nbsp;
                                                        <?php
                                                        echo Html::a(
                                                                html::tag('i', '', ['class' => 'zmdi zmdi-delete'])
                                                                , ['/rincian-biaya-sppd/delete', 'id' => $vv['id']]
                                                                , ['title' => 'Hapus Biaya',
                                                            'data' => [
                                                                'method' => 'post',
                                                                'confirm' => 'Yakin akan menghapus biaya ini?',
                                                            ],
                                                        ])
                                                        ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo Yii::$app->formatter->asDate($vv['tanggal']) ?></td>
                                                <td style="text-align: left"><?php echo $vv['uraian'] ?></td>
                                                <td><?php echo Yii::$app->formatter->asInteger($vv['volume']) ?></td>
                                                <td><?php echo $vv['nama_satuan'] ?></td>
                                                <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($vv['harga']) ?></td>
                                                <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($vv['total']) ?></td>
                                                <?php if ($vv['riil']): ?>
                                                    <td>Riil</td>
                                                    <?php
                                                    $subtotalBukti += $vv['harga'] * $vv['volume'];
                                                else:
                                                    $subtotalBukti += $vv['total_bukti'];
                                                    ?>
                                                    <td style="text-align: right">
                                                        <?php if ($vv['pdf_bukti']): ?>
                                                            <i class="zmdi zmdi-check-circle" style="font-size: 10px; color: yellow" title="Bukti sudah diupload"></i>
                                                        <?php endif; ?>
                                                        <?php echo Yii::$app->formatter->asDecimal($vv['total_bukti']) ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td style="text-align: left"><?php echo $vv['keterangan'] ?></td>
                                            </tr>
                                            <?php
                                            $subtotal += $vv['total'];
                                        endforeach;
                                        ?>
                                        <tr>
                                            <td colspan="6" style="text-align: right">Subtotal</td>
                                            <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($subtotal) ?></td>
                                            <td style="text-align: right"><?php echo Yii::$app->formatter->asDecimal($subtotalBukti) ?></td>
                                            <td></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr><td colspan="9">Tidak ada data</td></tr>
                                    <?php endif; ?>
                                </table>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr><th><?php echo $v ?></th></tr>
                        <tr>
                            <td>
                                <table style="width: 100%" class="table table-bordered table-condensed table-dark table-hover">
                                    <tr>
                                        <td></td>
                                        <th>Tanggal</th>
                                        <th>Uraian</th>
                                        <th>QTY</th>
                                        <th>Satuan</th>
                                        <th>Biaya</th>
                                        <th>Total</th>
                                        <th>Bukti</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    <tr><td colspan="9">Tidak ada data</td></tr>
                                </table>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php
                    $total += $subtotal;
                    $totalBukti += $subtotalBukti;
                endforeach;
                ?>
                <tr><td><strong>Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo Yii::$app->formatter->asDecimal($total) ?></strong></td></tr>
                <?php if ($model->status >= $model::STATUS_TERBIT): ?>
                    <tr><td><strong>Total Bukti&nbsp;: <?php echo Yii::$app->formatter->asDecimal($totalBukti) ?></strong></td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>