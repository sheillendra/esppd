<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use sheillendra\alpino\assets\AlpinoAsset;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $model common\models\RincianBiayaSppdExt */

$this->title = $model->uraian;
$this->params['breadcrumbs'][] = ['label' => 'SPPD', 'url' => ['/sppd']];
$this->params['breadcrumbs'][] = ['label' => 'Detail SPPD', 'url' => ['/sppd/view', 'id' => $model->sppd_id]];
$this->params['breadcrumbs'][] = 'Detail Biaya';

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'rincian-biaya-sppd';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'rincian-biaya-sppd';
?>
<div class="rincian-biaya-sppd-view">
    <div class="row">
        <div class="col-lg-3 col-md-12">
            <?php echo $this->render('@app/views/sppd/view_detail', ['model' => $model->sppd]) ?>
        </div>
        <?php if ($model->riil): ?>
            <div class="col-lg-8 col-md-12">Biaya ini pengeluaran riil yang tidak ada bukti-bukti</div>
        <?php else: ?>
            <?php if ($model->pdf_bukti): ?>
                <div class="col-lg-3 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Form</strong> Validasi<small>*Isian validasi dan detail register</small> </h2>
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>                           
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <?php $form = ActiveForm::begin(['action' => ['update-total-bukti', 'id' => $model->id]]) ?>
                            <div class="form-group">
                                <label class="control-label">Kategori</label>
                                <div class="form-control"><?php echo $model->kategoriBiaya->nama ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Uraian</label>
                                <div class="form-control"><?php echo $model->uraian ?></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Total</label>
                                <div class="form-control"><?php echo Yii::$app->formatter->asDecimal($model->total) ?></div>
                            </div>
                            <?php echo $form->field($model, 'total_bukti')->textInput() ?>
                            <?php if ($model->kategoriBiaya->detail_column): ?>
                                <?php
                                foreach ($model->kategoriBiaya->detail_column as $column):
                                    if (empty($column)) {
                                        continue;
                                    }
                                    ?>
                                    <?php if (method_exists('\common\widgets\ActiveField', $column)): ?>
                                        <?php echo $form->field($model, 'detail[' . $column . ']')->{$column}(); ?>
                                    <?php else : ?>
                                        <?php echo $form->field($model, 'detail[' . $column . ']')->textInput()->label(Inflector::camel2words(Inflector::id2camel($column, '_'))); ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="form-group">
                                <?php echo Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Bukti</strong> Biaya<small>*Informasi yang ada di bukti ini harus di input</small> </h2></ul>
                        </div>
                        <div class="body m-0 p-0">
                            <embed src="<?php echo Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/pdf/sppd-bukti', 'id' => $model->id]) ?>"
                                   type="application/pdf"
                                   width="100%"
                                   style="min-height: 450px" />
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-lg-8 col-md-12">Bukti belum ada</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
